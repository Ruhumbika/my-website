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
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.LicenseController = void 0;
const common_1 = require("@nestjs/common");
const license_service_1 = require("./license.service");
let LicenseController = class LicenseController {
    licenseService;
    constructor(licenseService) {
        this.licenseService = licenseService;
    }
    create(payload) {
        return this.licenseService.create(payload);
    }
    renew(id) {
        return this.licenseService.renew(id);
    }
    get(id) {
        return this.licenseService.get(id);
    }
    qr(id) {
        return this.licenseService.getQr(id);
    }
    verifyByCode(code) {
        return this.licenseService.verifyByCode(code);
    }
};
exports.LicenseController = LicenseController;
__decorate([
    (0, common_1.Post)(),
    __param(0, (0, common_1.Body)()),
    __metadata("design:type", Function),
    __metadata("design:paramtypes", [Object]),
    __metadata("design:returntype", void 0)
], LicenseController.prototype, "create", null);
__decorate([
    (0, common_1.Post)(':id/renew'),
    __param(0, (0, common_1.Param)('id')),
    __metadata("design:type", Function),
    __metadata("design:paramtypes", [String]),
    __metadata("design:returntype", void 0)
], LicenseController.prototype, "renew", null);
__decorate([
    (0, common_1.Get)(':id'),
    __param(0, (0, common_1.Param)('id')),
    __metadata("design:type", Function),
    __metadata("design:paramtypes", [String]),
    __metadata("design:returntype", void 0)
], LicenseController.prototype, "get", null);
__decorate([
    (0, common_1.Get)(':id/qr'),
    __param(0, (0, common_1.Param)('id')),
    __metadata("design:type", Function),
    __metadata("design:paramtypes", [String]),
    __metadata("design:returntype", void 0)
], LicenseController.prototype, "qr", null);
__decorate([
    (0, common_1.Get)('verify/:code'),
    __param(0, (0, common_1.Param)('code')),
    __metadata("design:type", Function),
    __metadata("design:paramtypes", [String]),
    __metadata("design:returntype", void 0)
], LicenseController.prototype, "verifyByCode", null);
exports.LicenseController = LicenseController = __decorate([
    (0, common_1.Controller)('licenses'),
    __metadata("design:paramtypes", [license_service_1.LicenseService])
], LicenseController);
//# sourceMappingURL=license.controller.js.map