import { Injectable } from '@nestjs/common';
import { PrismaService } from '../prisma/prisma.service';
import QRCode from 'qrcode';

@Injectable()
export class LicenseService {
  constructor(private readonly prisma: PrismaService) {}

  private generateLicenseCode(sequence: number) {
    const year = new Date().getFullYear();
    return `KIL-${year}-${sequence.toString().padStart(6, '0')}`;
  }

  async create(payload: { businessId: string; validityDays?: number }) {
    const validityDays = payload.validityDays ?? 365;

    const latest = await this.prisma.license.count();
    const code = this.generateLicenseCode(latest + 1);

    const baseUrl = process.env.PUBLIC_BASE_URL ?? 'http://localhost:4000';
    const verificationUrl = `${baseUrl}/licenses/verify/${encodeURIComponent(code)}`;

    const qrCodeSvg = await QRCode.toString(verificationUrl, { type: 'svg' });
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

  async renew(id: string, validityDays = 365) {
    const license = await this.prisma.license.findUnique({ where: { id } });
    if (!license) return null;

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

  async get(id: string) {
    return this.prisma.license.findUnique({ where: { id }, include: { business: true, payments: true } });
  }

  async getQr(id: string) {
    const lic = await this.prisma.license.findUnique({ where: { id } });
    return { qrCodeSvg: lic?.qrCodeSvg };
  }

  async verifyByCode(code: string) {
    const lic = await this.prisma.license.findUnique({ where: { licenseCode: code } });
    if (!lic) return { valid: false };
    const now = new Date();
    const valid = lic.status === 'VALID' && !!lic.expiryAt && lic.expiryAt > now;
    return { valid, licenseId: lic.id, businessId: lic.businessId, expiryAt: lic.expiryAt };
  }
}