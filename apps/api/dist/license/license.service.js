"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.LicenseService = void 0;
const common_1 = require("@nestjs/common");
const prisma_service_1 = require("../prisma/prisma.service");
const qrcode_1 = __importDefault(require("qrcode"));
let LicenseService = class LicenseService {
    prisma;
    constructor(prisma) {
        this.prisma = prisma;
    }
    generateLicenseCode(sequence) {
        const year = new Date().getFullYear();
        return `KIL-${year}-${sequence.toString().padStart(6, '0')}`;
    }
    async create(payload) {
        const validityDays = payload.validityDays ?? 365;
        const latest = await this.prisma.license.count();
        const code = this.generateLicenseCode(latest + 1);
        const baseUrl = process.env.PUBLIC_BASE_URL ?? 'http://localhost:4000';
        const verificationUrl = `${baseUrl}/licenses/verify/${encodeURIComponent(code)}`;
        const qrCodeSvg = await qrcode_1.default.toString(verificationUrl, { type: 'svg' });
        const now = new Date();
        const expiry = new Date(now.getTime() + validityDays * 24 * 60 * 60 * 1000);
        const license = await this.prisma.license.create({
            data: {
                licenseCode: code,
                status: 'VALID',
                issuedAt: now,
                expiryAt: expiry,
                verificationUrl,
                qrCodeSvg,
                businessId: payload.businessId,
            },
        });
        return license;
    }
    async renew(id, validityDays = 365) {
        const license = await this.prisma.license.findUnique({ where: { id } });
        if (!license)
            return null;
        const newExpiry = new Date((license.expiryAt ?? new Date()).getTime() + validityDays * 24 * 60 * 60 * 1000);
        const renewed = await this.prisma.license.update({
            where: { id },
            data: {
                expiryAt: newExpiry,
                renewalCount: license.renewalCount + 1,
                status: 'VALID',
            },
        });
        return renewed;
    }
    async get(id) {
        return this.prisma.license.findUnique({ where: { id }, include: { business: true, payments: true } });
    }
    async getQr(id) {
        const lic = await this.prisma.license.findUnique({ where: { id } });
        return { qrCodeSvg: lic?.qrCodeSvg };
    }
    async verifyByCode(code) {
        const lic = await this.prisma.license.findUnique({ where: { licenseCode: code } });
        if (!lic)
            return { valid: false };
        const now = new Date();
        const valid = lic.status === 'VALID' && !!lic.expiryAt && lic.expiryAt > now;
        return { valid, licenseId: lic.id, businessId: lic.businessId, expiryAt: lic.expiryAt };
    }
};
exports.LicenseService = LicenseService;
exports.LicenseService = LicenseService = __decorate([
    (0, common_1.Injectable)(),
    __metadata("design:paramtypes", [prisma_service_1.PrismaService])
], LicenseService);
//# sourceMappingURL=license.service.js.map