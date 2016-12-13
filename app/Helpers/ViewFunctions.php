<?php

	function convertDate($str, $format='m-d-Y'){
        if ($str == '' || $str === false)
            return '';
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $str);
        return date_format($date, $format);
    }

    function column($name, $text, $sort){
        echo $text;
        if ($sort == $name){
            echo '<img src="/Images/up.png">';
        }
        else if ($sort == "-$name"){
            echo '<img src="/Images/down.png">';
        }
    }

    function shortSummary($summary){
        if (strlen($summary) > 400){
            $summary = substr($summary, 0, 400) . "...";
        }
        return $summary;
    }

    function filter_form($filterInfo, $hasFilter){
    	$filters = $filterInfo['filters'];
    	$columns = $filterInfo['columns'];
    	$scope = $filterInfo['scope'];

    	echo '<div style="float:right; margin-bottom:20px;" id="filter_box">
    	<form id="filter_form">';
    	echo '<input type="hidden" name="columns" value="' . implode(',', $columns) . '"/>'; 
    	echo '<a class="FilterToggle" onclick="toggleFilter()">Advanced Filters</a> <br/>
            <div id="filter_body" ';
        if ($hasFilter == false){
            echo 'style="display:none;"';
        }
        echo '>
                <table>';
        	echo '<tr>';
        foreach($filters as $filter){
        	if ($filter['type'] == 'text'){
        		echo '<td><label style="top: -3px; position: relative; margin-left:5px;" for="filter_', $filter['name'], '">', $filter['text'], '</label>';
        		echo '<input type="text" style="width: 150px; margin-left: 10px;"  id="filter_', $filter['name'], '" name="', $filter['name'] , '" value="', $filter['value'], '">';
        	}
        	// else if ($filter['type'] == 'date'){
        	// 	$vals = explode(',', $filter['value']);
        	// 	echo '<td><label style="top: -3px; position: relative; margin-left:5px;" for="filter_', $filter['name'], '_from">', $filter['text'], ' From</label>';
        	// 	echo '<input type="text" id="filter_', $filter['name'], '_from" name="', $filter['name'], '_from" value="', $vals[0], '" class="datepicker txt FilterDate"></td>';
        	// 	echo '<td style="padding-left:20px;"><label style="top: -3px; position: relative; margin-left:5px;" for="filter_', $filter['name'], '_to">', $filter['text'], ' To</label>';
        	// 	echo '<input type="text" id="filter_', $filter['name'], '_to" name="', $filter['name'], '_to" value="', $vals[1],'" class="datepicker txt FilterDate"></td>';
        	// }

        	echo '</td>';
        }
        echo '        </tr></table>
                <br/>
                <div style="float:right;">
                <a class="mini-gold" style="cursor: pointer;padding: 9px;top: -5px;position: relative;" onclick="setFilter('. "'$scope'" . ');">Filter</a>
                </div>
                <div style="float:right;">
                <a class="mini-red" style="cursor: pointer;padding: 9px;top: -5px;position: relative; margin-right:10px;" onclick="resetFilter('. "'$scope'" . ');">Reset Filter</a>
                </div>
            </div>
        </form>
        </div>
        <div style="clear:both;"></div>';
    }

    function currentCoupon($coupons){
        foreach ($coupons as $coupon) {
            if ($coupon->isActive && !$coupon->isDeleted)
                return $coupon;
        }
        return NULL;
    }

    function getTime($timestr){
        $time = date_create($timestr);
        return date_format($time, 'm/d/Y g:i:sa');
    }

    function escapeJsonString($value) { // list from www.json.org: (\b backspace, \f formfeed)
        $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
        $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
        $result = str_replace($escapers, $replacements, $value);
        return $result;
    }


?>