import { Body, Controller, Get, Param, Post } from '@nestjs/common';
import { LicenseService } from './license.service';

@Controller('licenses')
export class LicenseController {
  constructor(private readonly licenseService: LicenseService) {}

  @Post()
  create(@Body() payload: any) {
    return this.licenseService.create(payload);
  }

  @Post(':id/renew')
  renew(@Param('id') id: string) {
    return this.licenseService.renew(id);
  }

  @Get(':id')
  get(@Param('id') id: string) {
    return this.licenseService.get(id);
  }

  @Get(':id/qr')
  qr(@Param('id') id: string) {
    return this.licenseService.getQr(id);
  }

  @Get('verify/:code')
  verifyByCode(@Param('code') code: string) {
    return this.licenseService.verifyByCode(code);
  }
}