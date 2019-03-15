<?php 
/*
* Template Name: Calendar
*/
get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <titlebar>
            <h1><?php the_title(); ?></h1>
    </titlebar>
        <?php
            $dateComponents = getdate();
            $year = $dateComponents['year'];
            $thismonth = $dateComponents['mon'];
            $thisday = $dateComponents['mday'];
            if($_GET['monthsshown'] != null) {
                $startmonth = $thismonth + intval($_GET['monthsshown']);
                $startyear = $year;
                if($startmonth > 12) {
                    $startmonth -= 12;
                    $startyear++;
                } 
                
            } else {
                $startmonth = $thismonth;
                $startyear = $year;
            }

            if($_GET['timerange'] != null) {
                $addmonths = intval($_GET['timerange']);    
            } else {
                $addmonths = 3;
            }

            $endmonth = $startmonth + $addmonths;
            $endyear = $startyear;
            if($endmonth > 12) {
               
                $endmonth -= 12;
                $endyear++;
            }

            $starttime = $startyear.sprintf("%02d", $startmonth).'01';
            $endtime = $endyear.sprintf("%02d", $endmonth).'01';

            $dateObj = DateTime::createFromFormat('!m', $startmonth);
            $startmonthname = $dateObj->format('F');

            $dateObj = DateTime::createFromFormat('!m', $endmonth);
            $endmonthname = $dateObj->format('F');


            unset($datepoints);
            $datepoints = array();
        ?>
        <column class="col-3">
            <?php 
            if($_GET['et'] != null) {
                $eventtypeterm = array();
                $eventtermnames = ' :';
                foreach($_GET['et'] as $check) {
                    array_push($eventtypeterm, $check);
                    $termname = get_term_by('slug', $check, 'event-type'); 
                    $eventtermnames .= ' '.$termname->name.',';
                    
                }
                $eventtermnames = substr($eventtermnames, 0, -1);
                $eventtypearg = array('taxonomy' => 'event-type', 'field' => 'slug', 'terms' => $eventtypeterm);
            }
            ?>
            
            <h3 class="nmb"><?php echo $startmonthname.' '.$startyear.' to '.$endmonthname.' '.$endyear.$eventtermnames; ?></h3>
            
            <div class="acf-map">
                <?php
            
                    if($_GET['countryselect'] != null) {
                        $csel = array(
                                'key'		=> 'country',
                                'compare'	=> 'IN',
                                'value'		=> $_GET['countryselect']
                            );
                    }
                
                    $eventargs = array (
                        'post_type' => 'event',
                        'suppress_filter' => true,

                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key'		=> 'start_date',
                                'compare'	=> 'BETWEEN',
                                'value'		=> array($starttime, $endtime)
                            ),
                            $csel,
                        ),
                        'tax_query' => array(
                            'relation' => 'AND',
                            $eventtypearg
                        )
                    );
                
                
                    $events = get_posts($eventargs);

                    if($events) :
                        foreach($events as $event) :
                            $calpoint = get_field('start_date', $event->ID, false, false);
                            $calpoint = new DateTime($calpoint);
                            if(get_field('event_type', $event->ID)) {
                                $evtype = get_field('event_type', $event->ID);  
                                $event_type_name = $evtype->name;
                                $event_type_slug = $evtype->slug;
                            } else {
                                $event_type_name = 'Non Sanctioned';
                                $event_type_slug = 'non-sanctioned';
                            }
                            
                            $location = get_field('map', $event->ID);
                            $stack = array($calpoint->format('j'), $calpoint->format('n'), $calpoint->format('Y'), get_the_title($event->ID), 'event', $event_type_name, get_the_permalink($event->ID), $location['address'], $event_type_slug);
                            array_push($datepoints, $stack);
                
                            if(get_field('end_date', $event->ID) && get_field('multi_date_event', $event->ID)) {
                                $endcalpoint = get_field('end_date', $event->ID, false, false);
                                $endcalpoint = new DateTime($endcalpoint);
                                $date1 = date_create($calpoint->format('Y').'-'.$calpoint->format('m').'-'.$calpoint->format('d'));
                                $date2 = date_create($endcalpoint->format('Y').'-'.$endcalpoint->format('m').'-'.$endcalpoint->format('d'));
                                $diff = date_diff($date1,$date2);
                                if($diff->d > 0) {
                                    for($nd = 1; $nd <= $diff->d; $nd++) {
                                        $calpoint->modify('+1 day');
                                        $stack = array($calpoint->format('j'), $calpoint->format('n'), $calpoint->format('Y'), get_the_title($event->ID), 'event event-cont', 'Day '.(1+$nd), get_the_permalink($event->ID), $location['address'], $event_type_slug);
                                        array_push($datepoints, $stack);
                                    }
                                    
                                }
                               /* $nextday = $calpoint->format('Y').''.$calpoint->format('m').''.($calpoint->format('d')+1);
                                $nextday = new DateTime($nextday);
                                $stack = array($nextday->format('j'), $nextday->format('n'), $nextday->format('Y'), get_the_title($event->ID), 'event', $evtype->name, get_the_permalink($event->ID), $location['address'], $evtype->slug);
                                array_push($datepoints, $stack);*/
                            
                            }
                
                
                            
                
                
                            
                            ?>
                                <div class="marker <?php echo $evtype->slug; ?>" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
                                    <h4><?php echo get_the_title($event->ID); ?></h4>
                                    <p class="event-type"><?php echo $evtype->name; ?></p>
                                    <p class="date"><?php echo $calpoint->format('j').$calpoint->format('S'). ' of '.$calpoint->format('F').' '.$calpoint->format('Y'); ?></p>
                                    <p class="address"><?php echo $location['address']; ?></p>
                                    
                                    <p><a href="<?php echo get_the_permalink($event->ID); ?>">View Event</a></p>
                                </div>    

                            <?php            
                        endforeach;
                    else : ?>
                       
                <?php
                    endif;
                ?>
                <?php
            
                    $products = get_posts(array (
                        'post_type' => 'product',
                        'posts_per_page' => -1,
                        'meta_query' => array(
                            array(
                                'key'		=> 'eta',
                                'compare'	=> 'BETWEEN',
                                'value'		=> array($starttime, $endtime)
                            )
                        ),
                    ));

                    if($products) {
                        foreach($products as $product) {
                            
                            $calpoint = get_field('eta', $product->ID, false, false);
                            $calpoint = new DateTime($calpoint);
                            
                            $evtypes = get_field('faction', $product->ID);
                            $fact = '';
                            if($evtypes) :
                                foreach($evtypes as $evtype) :
                                    $fact .= $evtype->name;
                            
                                endforeach;
                            endif;
                            
                            //$location = get_field('map', $event->ID); 
                
                            $stack = array($calpoint->format('j'), $calpoint->format('n'), $calpoint->format('Y'), get_the_title($product->ID), 'product', $fact, get_the_permalink($product->ID), 'Release');
                            array_push($datepoints, $stack);
                            
                            //array_push($datepoints, $stack);
                        }
                    }



                ?>
        
            </div>    
        </column>
        <column class="col-1 col-wrapper">
            <column class="col-1">
                <h3>Filter Events</h3>
                <form class="filter" method="get" action="">
                        <label for="countryselect">Country</label>                        
                        <select name="countryselect" id="countryselect">
                            <option value="">–</option>
                            <option value="AF" <?php if($_GET['countryselect'] == 'AF') echo 'selected'; ?>>Afghanistan</option>
                            <option value="AX">Åland Islands</option>
                            <option value="AL">Albania</option>
                            <option value="DZ">Algeria</option>
                            <option value="AS">American Samoa</option>
                            <option value="AD">Andorra</option>
                            <option value="AO">Angola</option>
                            <option value="AI">Anguilla</option>
                            <option value="AQ">Antarctica</option>
                            <option value="AG">Antigua and Barbuda</option>
                            <option value="AR">Argentina</option>
                            <option value="AM">Armenia</option>
                            <option value="AW">Aruba</option>
                            <option value="AU">Australia</option>
                            <option value="AT">Austria</option>
                            <option value="AZ">Azerbaijan</option>
                            <option value="BS">Bahamas</option>
                            <option value="BH">Bahrain</option>
                            <option value="BD">Bangladesh</option>
                            <option value="BB">Barbados</option>
                            <option value="BY">Belarus</option>
                            <option value="BE">Belgium</option>
                            <option value="BZ">Belize</option>
                            <option value="BJ">Benin</option>
                            <option value="BM">Bermuda</option>
                            <option value="BT">Bhutan</option>
                            <option value="BO">Bolivia, Plurinational State of</option>
                            <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                            <option value="BA">Bosnia and Herzegovina</option>
                            <option value="BW">Botswana</option>
                            <option value="BV">Bouvet Island</option>
                            <option value="BR">Brazil</option>
                            <option value="IO">British Indian Ocean Territory</option>
                            <option value="BN">Brunei Darussalam</option>
                            <option value="BG">Bulgaria</option>
                            <option value="BF">Burkina Faso</option>
                            <option value="BI">Burundi</option>
                            <option value="KH">Cambodia</option>
                            <option value="CM">Cameroon</option>
                            <option value="CA">Canada</option>
                            <option value="CV">Cape Verde</option>
                            <option value="KY">Cayman Islands</option>
                            <option value="CF">Central African Republic</option>
                            <option value="TD">Chad</option>
                            <option value="CL">Chile</option>
                            <option value="CN">China</option>
                            <option value="CX">Christmas Island</option>
                            <option value="CC">Cocos (Keeling) Islands</option>
                            <option value="CO">Colombia</option>
                            <option value="KM">Comoros</option>
                            <option value="CG">Congo</option>
                            <option value="CD">Congo, the Democratic Republic of the</option>
                            <option value="CK">Cook Islands</option>
                            <option value="CR">Costa Rica</option>
                            <option value="CI">Côte d'Ivoire</option>
                            <option value="HR">Croatia</option>
                            <option value="CU">Cuba</option>
                            <option value="CW">Curaçao</option>
                            <option value="CY">Cyprus</option>
                            <option value="CZ">Czech Republic</option>
                            <option value="DK">Denmark</option>
                            <option value="DJ">Djibouti</option>
                            <option value="DM">Dominica</option>
                            <option value="DO">Dominican Republic</option>
                            <option value="EC">Ecuador</option>
                            <option value="EG">Egypt</option>
                            <option value="SV">El Salvador</option>
                            <option value="GQ">Equatorial Guinea</option>
                            <option value="ER">Eritrea</option>
                            <option value="EE">Estonia</option>
                            <option value="ET">Ethiopia</option>
                            <option value="FK">Falkland Islands (Malvinas)</option>
                            <option value="FO">Faroe Islands</option>
                            <option value="FJ">Fiji</option>
                            <option value="FI">Finland</option>
                            <option value="FR">France</option>
                            <option value="GF">French Guiana</option>
                            <option value="PF">French Polynesia</option>
                            <option value="TF">French Southern Territories</option>
                            <option value="GA">Gabon</option>
                            <option value="GM">Gambia</option>
                            <option value="GE">Georgia</option>
                            <option value="DE">Germany</option>
                            <option value="GH">Ghana</option>
                            <option value="GI">Gibraltar</option>
                            <option value="GR">Greece</option>
                            <option value="GL">Greenland</option>
                            <option value="GD">Grenada</option>
                            <option value="GP">Guadeloupe</option>
                            <option value="GU">Guam</option>
                            <option value="GT">Guatemala</option>
                            <option value="GG">Guernsey</option>
                            <option value="GN">Guinea</option>
                            <option value="GW">Guinea-Bissau</option>
                            <option value="GY">Guyana</option>
                            <option value="HT">Haiti</option>
                            <option value="HM">Heard Island and McDonald Islands</option>
                            <option value="VA">Holy See (Vatican City State)</option>
                            <option value="HN">Honduras</option>
                            <option value="HK">Hong Kong</option>
                            <option value="HU">Hungary</option>
                            <option value="IS">Iceland</option>
                            <option value="IN">India</option>
                            <option value="ID">Indonesia</option>
                            <option value="IR">Iran, Islamic Republic of</option>
                            <option value="IQ">Iraq</option>
                            <option value="IE">Ireland</option>
                            <option value="IM">Isle of Man</option>
                            <option value="IL">Israel</option>
                            <option value="IT">Italy</option>
                            <option value="JM">Jamaica</option>
                            <option value="JP">Japan</option>
                            <option value="JE">Jersey</option>
                            <option value="JO">Jordan</option>
                            <option value="KZ">Kazakhstan</option>
                            <option value="KE">Kenya</option>
                            <option value="KI">Kiribati</option>
                            <option value="KP">Korea, Democratic People's Republic of</option>
                            <option value="KR">Korea, Republic of</option>
                            <option value="KW">Kuwait</option>
                            <option value="KG">Kyrgyzstan</option>
                            <option value="LA">Lao People's Democratic Republic</option>
                            <option value="LV">Latvia</option>
                            <option value="LB">Lebanon</option>
                            <option value="LS">Lesotho</option>
                            <option value="LR">Liberia</option>
                            <option value="LY">Libya</option>
                            <option value="LI">Liechtenstein</option>
                            <option value="LT">Lithuania</option>
                            <option value="LU">Luxembourg</option>
                            <option value="MO">Macao</option>
                            <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                            <option value="MG">Madagascar</option>
                            <option value="MW">Malawi</option>
                            <option value="MY">Malaysia</option>
                            <option value="MV">Maldives</option>
                            <option value="ML">Mali</option>
                            <option value="MT">Malta</option>
                            <option value="MH">Marshall Islands</option>
                            <option value="MQ">Martinique</option>
                            <option value="MR">Mauritania</option>
                            <option value="MU">Mauritius</option>
                            <option value="YT">Mayotte</option>
                            <option value="MX">Mexico</option>
                            <option value="FM">Micronesia, Federated States of</option>
                            <option value="MD">Moldova, Republic of</option>
                            <option value="MC">Monaco</option>
                            <option value="MN">Mongolia</option>
                            <option value="ME">Montenegro</option>
                            <option value="MS">Montserrat</option>
                            <option value="MA">Morocco</option>
                            <option value="MZ">Mozambique</option>
                            <option value="MM">Myanmar</option>
                            <option value="NA">Namibia</option>
                            <option value="NR">Nauru</option>
                            <option value="NP">Nepal</option>
                            <option value="NL">Netherlands</option>
                            <option value="NC">New Caledonia</option>
                            <option value="NZ">New Zealand</option>
                            <option value="NI">Nicaragua</option>
                            <option value="NE">Niger</option>
                            <option value="NG">Nigeria</option>
                            <option value="NU">Niue</option>
                            <option value="NF">Norfolk Island</option>
                            <option value="MP">Northern Mariana Islands</option>
                            <option value="NO">Norway</option>
                            <option value="OM">Oman</option>
                            <option value="PK">Pakistan</option>
                            <option value="PW">Palau</option>
                            <option value="PS">Palestinian Territory, Occupied</option>
                            <option value="PA">Panama</option>
                            <option value="PG">Papua New Guinea</option>
                            <option value="PY">Paraguay</option>
                            <option value="PE">Peru</option>
                            <option value="PH">Philippines</option>
                            <option value="PN">Pitcairn</option>
                            <option value="PL">Poland</option>
                            <option value="PT">Portugal</option>
                            <option value="PR">Puerto Rico</option>
                            <option value="QA">Qatar</option>
                            <option value="RE">Réunion</option>
                            <option value="RO">Romania</option>
                            <option value="RU">Russian Federation</option>
                            <option value="RW">Rwanda</option>
                            <option value="BL">Saint Barthélemy</option>
                            <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                            <option value="KN">Saint Kitts and Nevis</option>
                            <option value="LC">Saint Lucia</option>
                            <option value="MF">Saint Martin (French part)</option>
                            <option value="PM">Saint Pierre and Miquelon</option>
                            <option value="VC">Saint Vincent and the Grenadines</option>
                            <option value="WS">Samoa</option>
                            <option value="SM">San Marino</option>
                            <option value="ST">Sao Tome and Principe</option>
                            <option value="SA">Saudi Arabia</option>
                            <option value="SN">Senegal</option>
                            <option value="RS">Serbia</option>
                            <option value="SC">Seychelles</option>
                            <option value="SL">Sierra Leone</option>
                            <option value="SG">Singapore</option>
                            <option value="SX">Sint Maarten (Dutch part)</option>
                            <option value="SK">Slovakia</option>
                            <option value="SI">Slovenia</option>
                            <option value="SB">Solomon Islands</option>
                            <option value="SO">Somalia</option>
                            <option value="ZA">South Africa</option>
                            <option value="GS">South Georgia and the South Sandwich Islands</option>
                            <option value="SS">South Sudan</option>
                            <option value="ES">Spain</option>
                            <option value="LK">Sri Lanka</option>
                            <option value="SD">Sudan</option>
                            <option value="SR">Suriname</option>
                            <option value="SJ">Svalbard and Jan Mayen</option>
                            <option value="SZ">Swaziland</option>
                            <option value="SE">Sweden</option>
                            <option value="CH">Switzerland</option>
                            <option value="SY">Syrian Arab Republic</option>
                            <option value="TW">Taiwan, Province of China</option>
                            <option value="TJ">Tajikistan</option>
                            <option value="TZ">Tanzania, United Republic of</option>
                            <option value="TH">Thailand</option>
                            <option value="TL">Timor-Leste</option>
                            <option value="TG">Togo</option>
                            <option value="TK">Tokelau</option>
                            <option value="TO">Tonga</option>
                            <option value="TT">Trinidad and Tobago</option>
                            <option value="TN">Tunisia</option>
                            <option value="TR">Turkey</option>
                            <option value="TM">Turkmenistan</option>
                            <option value="TC">Turks and Caicos Islands</option>
                            <option value="TV">Tuvalu</option>
                            <option value="UG">Uganda</option>
                            <option value="UA">Ukraine</option>
                            <option value="AE">United Arab Emirates</option>
                            <option value="GB">United Kingdom</option>
                            <option value="US">United States</option>
                            <option value="UM">United States Minor Outlying Islands</option>
                            <option value="UY">Uruguay</option>
                            <option value="UZ">Uzbekistan</option>
                            <option value="VU">Vanuatu</option>
                            <option value="VE">Venezuela, Bolivarian Republic of</option>
                            <option value="VN">Viet Nam</option>
                            <option value="VG">Virgin Islands, British</option>
                            <option value="VI">Virgin Islands, U.S.</option>
                            <option value="WF">Wallis and Futuna</option>
                            <option value="EH">Western Sahara</option>
                            <option value="YE">Yemen</option>
                            <option value="ZM">Zambia</option>
                            <option value="ZW">Zimbabwe</option>
                        </select>

                            <?php $terms_type = get_terms('event-type'); $dettitle = '';
                                echo '<label for="et[]">Event Type</label>';
                                foreach ( $terms_type as $term_type ) : ?>
                                    <div class="checkbox-con">
                                        <div class="checkbox-div">
                                           <input type="checkbox" name="et[]" id="check-<?php echo $term_type->slug; ?>" value="<?php echo $term_type->slug; ?>" <?php 
                                                  foreach($_GET['et'] as $check) {
                                                        if($check == $term_type->slug && $selected != true) { 
                                                            echo 'checked'; $getvars .= '&et[]='.$term_type->slug;
                                                            $dettitle .= ' '.$term_type->name.',';
                                                        }	  
                                                  } ?>
                                            >
                                            <label for="check-<?php echo $term_type->slug; ?>"></label>
                                        </div>
                                        <p><?php echo $term_type->name; ?></p>
                                    </div>
                                <?php endforeach; ?>


                        <label for="monthshown">Show From</label>  
                        <?php /*?><select name="monthsshown" id="monthsshown">
                            <option value="-3" <?php if($_GET['monthsshown'] == '-3') echo 'selected'; ?>><?php $dateObj = DateTime::createFromFormat('!m', (($thismonth-3)%12)); echo $dateObj->format('F'); ?></option>

                            <option value="-2" <?php if($_GET['monthsshown'] == '-2') echo 'selected'; ?>><?php $dateObj = DateTime::createFromFormat('!m', (($thismonth-2)%12)); echo $dateObj->format('F'); ?></option>


                            <option value="-1" <?php if($_GET['monthsshown'] == '-1') echo 'selected'; ?>><?php $dateObj = DateTime::createFromFormat('!m', (($thismonth-1)%12)); echo $dateObj->format('F'); ?></option>

                            <option value="0" <?php if($_GET['monthsshown'] == '0' || !$_GET['monthsshown']) echo 'selected'; ?>><?php $dateObj = DateTime::createFromFormat('!m', (($thismonth)%12)); echo $dateObj->format('F').' (now)'; ?></option>

                            <option value="1" <?php if($_GET['monthsshown'] == '1') echo 'selected'; ?>><?php $dateObj = DateTime::createFromFormat('!m', ((1+$thismonth)%12)); echo $dateObj->format('F'); ?></option>
                            <option value="2" <?php if($_GET['monthsshown'] == '2') echo 'selected'; ?>><?php $dateObj = DateTime::createFromFormat('!m', ((2+$thismonth)%12)); echo $dateObj->format('F'); ?></option>
                            <option value="3" <?php if($_GET['monthsshown'] == '3') echo 'selected'; ?>><?php $dateObj = DateTime::createFromFormat('!m', ((3+$thismonth)%12)); echo $dateObj->format('F'); ?></option>
                            <option value="3" <?php if($_GET['monthsshown'] == '4') echo 'selected'; ?>><?php $dateObj = DateTime::createFromFormat('!m', ((4+$thismonth)%12)); echo $dateObj->format('F'); ?></option>
                            <option value="3" <?php if($_GET['monthsshown'] == '5') echo 'selected'; ?>><?php $dateObj = DateTime::createFromFormat('!m', ((5+$thismonth)%12)); echo $dateObj->format('F'); ?></option>
                            <option value="6" <?php if($_GET['monthsshown'] == '6') echo 'selected'; ?>><?php $dateObj = DateTime::createFromFormat('!m', ((6+$thismonth)%12)); echo $dateObj->format('F'); ?></option>
                        </select>
                        <label for="timerange">Time Range</label>  
                        <select name="timerange" id="timerange">
                            <option value="1" <?php if($_GET['timerange'] == '1') echo 'selected'; ?>>1 month</option>
                            <option value="2" <?php if($_GET['timerange'] == '2') echo 'selected'; ?>>2 months</option>
                            <option value="3" <?php if($_GET['timerange'] == '3' || !$_GET['timerange']) echo 'selected'; ?>>3 months</option>
                            <option value="6" <?php if($_GET['timerange'] == '6') echo 'selected'; ?>>6 months</option>
                            <option value="9" <?php if($_GET['timerange'] == '9') echo 'selected'; ?>>9 months</option>
                            <option value="12" <?php if($_GET['timerange'] == '12') echo 'selected'; ?>>1 year</option>
                        </select><?php */?>
                        <input type="submit" value="FILTER">
                    </form>    
            </column>
            <column class="col-1">
                <h3>Create new Event</h3>
                <?php echo get_field('create_event_text', 'options'); ?>
                <p class="right-align"><a class="button" href="https://academy-pilot.com/create-event/">Create Event</a></p>
                
            </column>
        </column>
            


        
        
    <?php 
        $calmonth = $startmonth;
        $calyear = $startyear;
        if($_GET['monthsshown'] <= 0) {
            $reached = false;
        } else {
            $reached = true;
        }

        for($t = 0; $t < $addmonths; $t++) : 
            
    ?>
        
	    <column class="col-2">
        	<div class="calendar">
                <div class="cal-header">
                    <div class="cal-title"><h3><span class="cal-title-month"><?php $monthObj = DateTime::createFromFormat('!m', $calmonth);
 echo $monthObj->format('F'); ?></span>&nbsp;<span class="cal-title-year"><?php echo $calyear; ?></span></h3></div>
                </div>
                
                <div class="week-days-title">
                    <div class="week-day">Mon</div>
                    <div class="week-day">Tue</div>
                    <div class="week-day">Wen</div>
                    <div class="week-day">Thu</div>
                    <div class="week-day">Fri</div>
                    <div class="week-day">Sat</div>
                    <div class="week-day">Sun</div>

                </div>
                <div class="day-con">
                    <?php 
                        $curday = 0;
                        
                        

                        $days_in_month = cal_days_in_month(0, $calmonth, $calyear) ;
                        $first_day_string = '1-'.$calmonth.'-'.$calyear;
                        $first_day_of_month=intval(date('w', strtotime($first_day_string))-1);

                        if($first_day_of_month< 0) { $first_day_of_month = 6; }

                        for($d = ($first_day_of_month*-1)+1; $d <= $days_in_month; $d++) {
                            $curday++;
                            if($curday%7 == 1) {
                                echo '<div class="week-con">';
                            }
                            if($d <= 0) {
                                echo '<day class="noshow"></day>';
                            } else {
                                if($thisday == $d && $thismonth == $calmonth && $year == $calyear) { 
                                    echo '<day class="thisday">';
                                    $reached = true;
                                } else {
                                    if($reached) {
                                        echo '<day>';
                                    } else {
                                        echo '<day class="past">';
                                    }
                                }
                                echo '<daydate><p>'.$d.'</p></daydate>';
                                    foreach($datepoints as $datepoint) :
                                        if($d == $datepoint[0] && $calmonth == $datepoint[1] && $calyear == $datepoint[2]) :
                                            echo '<a class="'.$datepoint[4].' '.$datepoint[8].'" href="'.$datepoint[6].'">';
                                                echo '<div class="infobox"><p class="ptitle">'.$datepoint[3].'</p><p  class="ptype">'.$datepoint[5].'</p><p>'.$datepoint[7].'</p></div>';        
                                            echo '</a>';
                                        endif;
                                    endforeach;

                                echo '</day>';    
                            }

                            if($curday%7 == 0) {
                                echo '</div>';
                            }
                        }

                    ?>
                    <?php 
                        if($curday%7 != 0) {
                            for($d = 1; $d <= (7-$curday%7); $d++) {    
                                echo '<day class="noshow"></day>';    
                            }
                            echo '</div>';
                        }
                    ?> 
                </div>
            </div>    
                
                
                
 
            
        </column>
    
    <?php 
        $calmonth++;

        if($calmonth > 12) {
            $calmonth = 1;
            $calyear++;
        }
        endfor; 
    ?>    
<?php endwhile; ?>
<?php get_footer(); ?>
<?php include('mapscript.php'); ?>