<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FunctionGetBalancePackagingLotByPackagingLotID extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE FUNCTION `getBalancePackagingLotByPackagingLotID`(`Pac_Lot_id` INT) RETURNS DECIMAL(18, 3)
            BEGIN
                DECLARE lot_qty   DECIMAL(18, 3);
                DECLARE lot_cut   DECIMAL(18, 3);
                DECLARE lot_return   DECIMAL(18, 3);
                DECLARE lot_claim   DECIMAL(18, 3);
                DECLARE lot_sum   DECIMAL(18, 3);

                    SELECT  sum(p.qty) INTO lot_qty
                    FROM 	packaging_lots p
                    WHERE   p.id = Pac_Lot_id
                    AND p.action=4;
                        IF (lot_qty is null) THEN
                            set lot_qty = 0;
                        end if;

                    SELECT sum(pcr.qty) INTO lot_cut
                    FROM packaging_cut_returns pcr
                    WHERE pcr.action = 1
                    AND pcr.reserve = 1
                    AND pcr.packaging_lot_id = Pac_Lot_id;
                        IF (lot_cut is null) THEN
                            set lot_cut = 0;
                        end if;

                    SELECT sum(pcr.qty) INTO lot_return
                    FROM packaging_cut_returns pcr
                    WHERE pcr.action = 2
                    AND pcr.reserve = 1
                    AND pcr.packaging_lot_id = Pac_Lot_id;
                        IF (lot_return is null) THEN
                            set lot_return = 0;
                        end if;

                        SELECT sum(pcr.qty) INTO lot_claim
                    FROM packaging_cut_returns pcr
                    WHERE pcr.action = 4
                    AND pcr.reserve = 1
                    AND pcr.packaging_lot_id = Pac_Lot_id;
                        IF (lot_claim is null) THEN
                            set lot_claim = 0;
                        end if;

                    SET lot_sum = lot_qty - lot_cut + lot_return + lot_claim;

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
        DB::unprepared('DROP FUNCTION getBalancePackagingLotByPackagingLotID');
    }
}
