import { Injectable } from '@nestjs/common';
import { PrismaService } from '../prisma/prisma.service';

@Injectable()
export class BusinessService {
  constructor(private readonly prisma: PrismaService) {}

  async create(payload: any) {
    const { name, category, tin, address, ward, district, region, latitude, longitude, ownerId } = payload;
    const mapLink = latitude && longitude ? `https://www.google.com/maps?q=${latitude},${longitude}` : undefined;
    return this.prisma.business.create({
      data: {
        name,
        category,
        tin,
        address,
        ward,
        district,
        region,
        latitude,
        longitude,
        mapLink,
        ownerId,
      },
    });
  }

  async list(params: { q?: string; status?: string; skip: number; take: number }) {
    const { q, skip, take } = params;
    return this.prisma.business.findMany({
      where: q
        ? {
            OR: [
              { name: { contains: q } },
              { category: { contains: q } },
              { tin: { contains: q } },
            ],
          }
        : undefined,
      include: {
        licenses: {
          orderBy: { createdAt: 'desc' },
          take: 1,
        },
      },
      skip,
      take,
      orderBy: { createdAt: 'desc' },
    });
  }

  async get(id: string) {
    return this.prisma.business.findUnique({
      where: { id },
      include: {
        licenses: { orderBy: { createdAt: 'desc' } },
        inspections: true,
      },
    });
  }

  async update(id: string, payload: any) {
    const { latitude, longitude } = payload;
    const mapLink = latitude && longitude ? `https://www.google.com/maps?q=${latitude},${longitude}` : undefined;
    return this.prisma.business.update({
      where: { id },
      data: { ...payload, mapLink },
    });
  }
}