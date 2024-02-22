<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FunctionGetBalanceMaterialLotByMaterialLotID extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        DB::unprepared('
        CREATE FUNCTION `getBalanceMaterialLotByMaterialLotID`(`Mat_Lot_id` INT) RETURNS DECIMAL(18, 3)
            BEGIN
                DECLARE lot_weight   DECIMAL(18, 3);
                DECLARE lot_cut   DECIMAL(18, 3);
                DECLARE lot_return   DECIMAL(18, 3);
                DECLARE lot_sum   DECIMAL(18, 3);

                    SELECT  sum(m.weight_total) INTO lot_weight
                    FROM 	material_lots m
                    WHERE   m.action=4
                    AND   m.id = Mat_Lot_id;
                        IF (lot_weight is null) THEN
                            set lot_weight = 0;
                        end if;

                    SELECT sum(mcr.weight) INTO lot_cut
                    FROM material_cut_returns mcr
                    WHERE mcr.action = 1
                    AND mcr.reserve = 1
                    AND mcr.material_lot_id = Mat_Lot_id;
                        IF (lot_cut is null) THEN
                            set lot_cut = 0;
                        end if;

                    SELECT sum(mcr.weight) INTO lot_return
                    FROM material_cut_returns mcr
                    WHERE mcr.action = 2
                    AND mcr.reserve = 1
                    AND mcr.material_lot_id = Mat_Lot_id;
                        IF (lot_return is null) THEN
                            set lot_return = 0;
                        end if;

                    SET lot_sum = lot_weight - lot_cut + lot_return;

                RETURN lot_sum;

            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION getBalanceMaterialLotByMaterialLotID');
    }
}
