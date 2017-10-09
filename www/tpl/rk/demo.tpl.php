<?php
echo "<script language=JavaScript ".
      "src='https://auth.robokassa.ru/Merchant/PaymentForm/FormFLS.js?".
      "MrchLogin={$rkDemo->mrh_login}&OutSum={$rkDemo->out_summ}&InvId={$rkDemo->inv_id}&IncCurrLabel={$rkDemo->in_curr}".
      "&Desc={$rkDemo->inv_desc}&SignatureValue={$rkDemo->crc}&Shp_item={$rkDemo->shp_item}".
      "&Culture={$rkDemo->culture}&Encoding={$rkDemo->encoding}&isTest=1'></script>";
