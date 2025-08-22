import { Body, Controller, Get, Param, Post, Put, Query } from '@nestjs/common';
import { BusinessService } from './business.service';

@Controller('businesses')
export class BusinessController {
  constructor(private readonly businessService: BusinessService) {}

  @Post()
  create(@Body() payload: any) {
    return this.businessService.create(payload);
  }

  @Get()
  list(
    @Query('q') q?: string,
    @Query('status') status?: string,
    @Query('skip') skip = '0',
    @Query('take') take = '20',
  ) {
    return this.businessService.list({ q, status, skip: Number(skip), take: Number(take) });
  }

  @Get(':id')
  get(@Param('id') id: string) {
    return this.businessService.get(id);
  }

  @Put(':id')
  update(@Param('id') id: string, @Body() payload: any) {
    return this.businessService.update(id, payload);
  }
}