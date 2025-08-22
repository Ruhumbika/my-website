import { PrismaService } from '../prisma/prisma.service';
export declare class LicenseService {
    private readonly prisma;
    constructor(prisma: PrismaService);
    private generateLicenseCode;
    create(payload: {
        businessId: string;
        validityDays?: number;
    }): Promise<{
        id: string;
        createdAt: Date;
        updatedAt: Date;
        licenseCode: string;
        status: import("@prisma/client").$Enums.LicenseStatus;
        issuedAt: Date | null;
        expiryAt: Date | null;
        renewalCount: number;
        qrCodeSvg: string | null;
        verificationUrl: string | null;
        businessId: string;
    }>;
    renew(id: string, validityDays?: number): Promise<{
        id: string;
        createdAt: Date;
        updatedAt: Date;
        licenseCode: string;
        status: import("@prisma/client").$Enums.LicenseStatus;
        issuedAt: Date | null;
        expiryAt: Date | null;
        renewalCount: number;
        qrCodeSvg: string | null;
        verificationUrl: string | null;
        businessId: string;
    } | null>;
    get(id: string): Promise<({
        business: {
            name: string;
            category: string;
            tin: string | null;
            address: string | null;
            ward: string | null;
            district: string | null;
            region: string | null;
            latitude: number | null;
            longitude: number | null;
            ownerId: string;
            id: string;
            createdAt: Date;
            updatedAt: Date;
            mapLink: string | null;
            complianceScore: number;
        };
        payments: {
            id: string;
            createdAt: Date;
            status: import("@prisma/client").$Enums.PaymentStatus;
            licenseId: string;
            amount: number;
            currency: string;
            method: import("@prisma/client").$Enums.PaymentMethod;
            transactionRef: string | null;
            receiptUrl: string | null;
        }[];
    } & {
        id: string;
        createdAt: Date;
        updatedAt: Date;
        licenseCode: string;
        status: import("@prisma/client").$Enums.LicenseStatus;
        issuedAt: Date | null;
        expiryAt: Date | null;
        renewalCount: number;
        qrCodeSvg: string | null;
        verificationUrl: string | null;
        businessId: string;
    }) | null>;
    getQr(id: string): Promise<{
        qrCodeSvg: string | null | undefined;
    }>;
    verifyByCode(code: string): Promise<{
        valid: boolean;
        licenseId?: undefined;
        businessId?: undefined;
        expiryAt?: undefined;
    } | {
        valid: boolean;
        licenseId: string;
        businessId: string;
        expiryAt: Date | null;
    }>;
}
