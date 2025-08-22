import { BusinessService } from './business.service';
export declare class BusinessController {
    private readonly businessService;
    constructor(businessService: BusinessService);
    create(payload: any): Promise<{
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
    }>;
    list(q?: string, status?: string, skip?: string, take?: string): Promise<({
        licenses: {
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
        }[];
    } & {
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
    })[]>;
    get(id: string): Promise<({
        licenses: {
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
        }[];
        inspections: {
            id: string;
            createdAt: Date;
            status: import("@prisma/client").$Enums.InspectionStatus;
            businessId: string;
            scheduledAt: Date | null;
            notes: string | null;
            outcome: string | null;
            inspectorId: string | null;
        }[];
    } & {
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
    }) | null>;
    update(id: string, payload: any): Promise<{
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
    }>;
}
