import { Module } from '@nestjs/common';
import { ConfigModule } from '@nestjs/config';
import { AppController } from './app.controller';
import { AppService } from './app.service';
import { PrismaService } from './prisma/prisma.service';
import { BusinessModule } from './business/business.module';
import { LicenseModule } from './license/license.module';

@Module({
  imports: [
    ConfigModule.forRoot({ isGlobal: true }),
    BusinessModule,
    LicenseModule,
  ],
  controllers: [AppController],
  providers: [AppService, PrismaService],
})
export class AppModule {}
