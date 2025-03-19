<?

function dump($r)
{
	global $USER;
	if($USER->IsAdmin()) {
		echo '<pre>';
		print_r($r);
		echo '</pre>';
	}
}

AddEventHandler("subscribe", "BeforePostingSendMail", "BeforePostingSendMailHandler");
function BeforePostingSendMailHandler($arFields)
{

    $rs = CSubscription::GetByEmail($arFields["EMAIL"]);
    $unsubsLink = '';
    if($ar = $rs->Fetch())	$unsubsLink = '?ID='.$ar['ID'].'&CONFIRM_CODE='.$ar['CONFIRM_CODE'].'&action=unsubscribe';
    $arFields["BODY"] = str_replace("#UNSUBSCRIBE#", $unsubsLink, $arFields["BODY"]);    

    return $arFields;
}


AddEventHandler("subscribe", "OnStartSubscriptionUpdate", "OnStartSubscriptionUpdateHandler");
function OnStartSubscriptionUpdateHandler($arFields)
{
	if($arFields['ACTIVE'] == 'N' && !empty($arFields['ID'])) {
		CSubscription::Delete($arFields['ID']);
		LocalRedirect('/subscribe/?subs=deleted');
	}
	
}

function num_decline( $number, $titles, $show_number = 1 ){
    
    if( is_string( $titles ) )
        $titles = preg_split( '/, */', $titles );
        
        // когда указано 2 элемента
        if( empty( $titles[2] ) )
            $titles[2] = $titles[1];
            
            $cases = [ 2, 0, 1, 1, 1, 2 ];
            
            $intnum = abs( (int) strip_tags( $number ) );
            
            $title_index = ( $intnum % 100 > 4 && $intnum % 100 < 20 )
            ? 2
            : $cases[ min( $intnum % 10, 5 ) ];
            
            return ( $show_number ? "$number " : '' ) . $titles[ $title_index ];
}

