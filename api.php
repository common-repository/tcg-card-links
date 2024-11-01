 <?php
 
 if( !isset($_GET['c']) || !isset($_GET['s']) || !isset($_GET['pk']))
		return;
	
	if( get_magic_quotes_gpc() ){
		$_GET['c'] = stripslashes( $_GET['c'] );
		$_GET['s'] = stripslashes( $_GET['s'] );
		$_GET['pk'] = stripslashes( $_GET['pk'] );
	}
		
$xml=simplexml_load_file("http://partner.tcgplayer.com/x3/phl.asmx/p?pk=". urlencode( $_GET['pk'] )."&p=". urlencode( $_GET['c'] )."&s=". urlencode( $_GET['s'] ));
$id= $xml->product[0]->id;
$hiprice= $xml->product[0]->hiprice;
$lowprice= $xml->product[0]->lowprice;
$avgprice= $xml->product[0]->avgprice;
$foilavgprice= $xml->product[0]->foilavgprice;
$link= $xml->product[0]->link;
?> 
<div style="border: #2C6285 1px solid; background: #FFFFFF; width: 230px; height:390px">		


	<div style="border-bottom: #2c6285 2px solid; background-color: #e8e8e8;">
		<div style="width: 230px; border: 0; margin: 0; padding: 0;">
			<div style="float: left; width: 76px; text-align: center; font-size: 7pt; font-family: Arial;">

				Low

			</div>
			<div style="float: left; width: 76px; text-align: center; font-size: 7pt; font-family: Arial;">

				Mid

			</div>
			<div style="float: left; width: 76px; text-align: center; font-size: 7pt; font-family: Arial;">

				High

			</div>
		</div>
		<div style="width: 230px; border: 0; margin: 0; padding: 0; clear: both;">

			<div style="float: left; width: 76px; text-align: center; font-size: 8pt; font-family: Arial; font-weight: bold; background-color: #D9FCD1; padding: 2px 0;">
				<?php echo $lowprice; ?>
			</div>

			<div style="float: left; width: 76px; text-align: center; font-size: 8pt; font-family: Arial; font-weight: bold; background-color: #D1DFFC; padding: 2px 0;">
				<?php echo $avgprice; ?>
			</div>

			<div style="float: left; width: 76px; text-align: center; font-size: 8pt; font-family: Arial; font-weight: bold; background-color: #FCD1D1; padding: 2px 0;">
				<?php echo $hiprice; ?>
			</div>
		</div>
		<span style="display: block; clear: both;"></span>
	</div>

	<div style="height: 5px; width: 230px; line-height: 5px"></div>			

	<center>

				<div style="height: 300px; width: 215px; overflow: hidden; padding: 0; margin: 0; background-color: white; border: 0; margin: 0; padding: 0;">
					<div style="width: 215px; height: 300px; background: url('http://magic.tcgplayer.com/images/cardbg.jpg') top left no-repeat;">
						<img style="margin: 7px 7px 8px 8px; width: 200px; height: 285px" src="http://i.tcgplayer.com/<?php echo $id; ?>.jpg" width="200" height="285" border="0" OnError="this.src='http://magic.tcgplayer.com/db/cards/0.jpg'" alt="Lotus Cobra">
					</div>
				</div>
</center>
				<div style="padding: 6px 0px 4px 1px; height: 35px; width: 230px; text-align: center;">
					<div style="background: url('http://magic.tcgplayer.com/images/hovercart.jpg') top left no-repeat; height: 35px; width: 225px; margin: 0 auto;">
						<div style="width: 178px; text-align: center; font-size: 8pt; font-family: Arial; line-height: 12px; height: 25px; padding: 5px 0px 0px 47px;">
							<b>Buy from 500+ Vendors<BR>
							For as low as
								<font color=red>
<?php echo $lowprice; ?>
								</font>
							!</b>
						</div>
					</div>
				</div>
	
</div>