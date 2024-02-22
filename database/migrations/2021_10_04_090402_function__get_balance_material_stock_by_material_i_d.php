<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FunctionGetBalanceMaterialStockByMaterialID extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        DB::unprepared('
        CREATE FUNCTION `getBalanceMaterialStockByMaterialID`(`Mat_id` INT) RETURNS DECIMAL(18, 3)
            BEGIN
                DECLARE lot_weight   DECIMAL(18, 3);
                DECLARE lot_cut   DECIMAL(18, 3);
                DECLARE lot_return   DECIMAL(18, 3);
                DECLARE lot_sum   DECIMAL(18, 3);

                    SELECT  sum(m.weight_total) INTO lot_weight
                    FROM 	material_lots m
                    WHERE   m.action=4
                    AND   material_id = Mat_id;
                        IF (lot_weight is null) THEN
                            set lot_weight = 0;
                        end if;

                    SELECT sum(mcr.weight) INTO lot_cut
                    FROM material_cut_returns mcr
                    JOIN material_lots ml
                    ON mcr.material_lot_id = ml.id
                    JOIN materials m
                    ON ml.material_id = m.id
                    WHERE mcr.action=1
                    AND m.id = Mat_id;
                        IF (lot_cut is null) THEN
                            set lot_cut = 0;
                        end if;

                    SELECT sum(mcr.weight) INTO lot_return
                    FROM material_cut_returns mcr
                    JOIN material_lots ml
                    ON mcr.material_lot_id = ml.id
                    JOIN materials m
                    ON ml.material_id = m.id
                    WHERE mcr.action=2
                    AND m.id = Mat_id;
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
        DB::unprepared('DROP FUNCTION getBalanceMaterialStockByMaterialID');
    }
}
