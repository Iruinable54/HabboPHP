<?php
/********************************************************************************
 MachForm
  
 Copyright 2007-2012 Appnitro Software. This code cannot be redistributed without
 permission from http://www.appnitro.com/
 
 More info at: http://www.appnitro.com/
 ********************************************************************************/
	
	//generate color picker boxes
	function get_color_picker_markup(){
		$color_picker_markup =<<<EOT
												<ul class="et_color_picker">
													<li id="li_transparent" style="background-image: url('images/icons/colorbox_minus.png');background-color: transparent"></li>
													<li style="background-color: #000000"></li>
													<li style="background-color: #444444"></li>
													<li style="background-color: #666666"></li>
													<li style="background-color: #999999"></li>
													<li style="background-color: #CDCDCD"></li>
													<li style="background-color: #ECECEC"></li>
													<li style="background-color: #FFFFFF"></li>
													<li style="background-color: #1693A5"></li>
													<li style="background-color: #FBB829"></li>
													<li style="background-color: #CDD7B6"></li>
													<li style="background-color: #FF0000"></li>
													<li style="background-color: #FF0066"></li>
													<li style="background-color: #556270"></li>
													<li style="background-color: #ADD8C7"></li>
													<li style="background-color: #333333"></li>
													<li style="background-color: #FCFBE3"></li>
													<li style="background-color: #F0F0D8"></li>
													<li style="background-color: #F02311"></li>
													<li style="background-color: #FF9900"></li>
													<li style="background-color: #800F25"></li>
													<li style="background-color: #2A8FBD"></li>
													<li style="background-color: #CCFF00"></li>
													<li style="background-color: #A40802"></li>
													<li style="background-color: #FF5EAA"></li>
													<li style="background-color: #D8D8C0"></li>
													<li style="background-color: #6CDFEA"></li>
													<li style="background-color: #AD234B"></li>
													<li style="background-color: #666666"></li>
													<li style="background-color: #F0F0F0"></li>
													<li style="background-color: #77CCA4"></li>
													<li style="background-color: #FF0033"></li>
													<li style="background-color: #FE4365"></li>
													<li style="background-color: #025D8C"></li>
													<li style="background-color: #7F94B0"></li>
													<li style="background-color: #C7F464"></li>
													<li style="background-color: #D9FFA9"></li>
													<li style="background-color: #FC0F3E"></li>
													<li style="background-color: #D2E4FC"></li>
													<li style="background-color: #948C75"></li>
													<li style="background-color: #FFFF00"></li>
													<li style="background-color: #CCCCCC"></li>
													<li style="background-color: #FF6666"></li>
													<li style="background-color: #FFCC00"></li>
													<li style="background-color: #F4FCE8"></li>
													<li style="background-color: #999999"></li>
													<li style="background-color: #F7FDFA"></li>
													<li style="background-color: #7FAF1B"></li>
													<li style="background-color: #C0ADDB"></li>
													<li style="background-color: #A0D4A4"></li>
													<li style="background-color: #A1BEE6"></li>
													<li style="background-color: #FF6600"></li>
													<li style="background-color: #7FFF24"></li>
													<li style="background-color: #FEF9F0"></li>
													<li style="background-color: #0B8C8F"></li>
													<li style="background-color: #01D2FF"></li>
													<li style="background-color: #CAE8A2"></li>
													<li style="background-color: #FF5500"></li>
													<li style="background-color: #A80000"></li>
													<li style="background-color: #D70044"></li>
													<li style="background-color: #630947"></li>
													<li style="background-color: #515151"></li>
													<li style="background-color: #FF8800"></li>
													<li style="background-color: #AB0743"></li>
													<li style="background-color: #369699"></li>
													<li style="background-color: #520039"></li>
													<li style="background-color: #D7217E"></li>
													<li style="background-color: #D9E68E"></li>
													<li style="background-color: #107FC9"></li>
													<li style="background-color: #4F4E57"></li>
													<li style="background-color: #A8C0A8"></li>
													<li style="background-color: #44AA55"></li>
													<li style="background-color: #C0D8D8"></li>
													<li style="background-color: #FFA4A0"></li>
													<li style="background-color: #E3F6F3"></li>
													<li style="background-color: #F5F3E5"></li>
													<li style="background-color: #F4FFF9"></li>
													<li style="background-color: #919999"></li>
													<li style="background-color: #FF6B6B"></li>
													<li style="background-color: #C9E69A"></li>
													<li style="background-color: #EDF7FF"></li>
													<li style="background-color: #F56991"></li>
													<li style="background-color: #036564"></li>
													<li style="background-color: #E45635"></li>
													<li style="background-color: #D3B2D1"></li>
													<li style="background-color: #8EAFD1"></li>
													<li style="background-color: #FF9500"></li>
													<li style="background-color: #BAE4E5"></li>
													<li style="background-color: #FAF2F8"></li>
													<li style="background-color: #B1D58B"></li>
													<li style="background-color: #F0D878"></li>
													<li style="background-color: #D8F0F0"></li>
													<li style="background-color: #FFFFCC"></li>
													<li style="background-color: #FFD0D4"></li>
													<li style="background-color: #EFFAB4"></li>
													<li style="background-color: #F5AA1A"></li>
													<li style="background-color: #FFCCCC"></li>
													<li style="background-color: #D5D6CB"></li>
													<li style="background-color: #F0F0C0"></li>
													<li style="background-color: #82AEC8"></li>
													<li style="background-color: #69D2E7"></li>
													<li style="background-color: #B3C7EB"></li>
													<li style="background-color: #87D69B"></li>
													<li style="background-color: #ECCD35"></li>
													<li style="background-color: #F9CDAD"></li>
													<li style="background-color: #E0B5CB"></li>
													<li style="background-color: #484848"></li>
													<li style="background-color: #FF8080"></li>
													<li style="background-color: #ADDDEB"></li>
													<li style="background-color: #E9ECD9"></li>
													<li style="background-color: #BBC793"></li>
													<li style="background-color: #7BA5D1"></li>
													<li style="background-color: #C4CDE6"></li>
													<li style="background-color: #BFA76F"></li>
													<li style="background-color: #814444"></li>
													<li style="background-color: #4E6189"></li>
													<li style="background-color: #9AE4E8"></li>
													<li style="background-color: #BFA76F"></li>
													<li style="background-color: #FF4F4F"></li>
													<li style="background-color: #990000"></li>
													<li style="background-color: #006666"></li>
													<li style="background-color: #F74427"></li>
													<li style="background-color: #0E4E5A"></li>
													<li style="background-color: #C20562"></li>
													<li style="background-color: #A662DE"></li>
													<li style="background-color: #ADC7BE"></li>
													<li style="background-color: #F38630"></li>
													<li style="background-color: #FF005E"></li>
													<li style="background-color: #301830"></li>
													<li style="background-color: #FFFB00"></li>
													<li style="background-color: #FF2A00"></li>
													<li style="background-color: #EBEBEB"></li>
													<li style="background-color: #F0EEE1"></li>
													<li style="background-color: #FF7300"></li>
													<li style="background-color: #C0FF33"></li>
													<li style="background-color: #00A0C6"></li>
													<li style="background-color: #FFD700"></li>
													<li style="background-color: #9D007A"></li>
													<li style="background-color: #81971A"></li>
													<li style="background-color: #C7E2C3"></li>
													<li style="background-color: #F8ECC9"></li>
													<li style="background-color: #800149"></li>
													<li style="background-color: #BD8B64"></li>
													<li style="background-color: #8ABFCF"></li>
													<li style="background-color: #F0D8C0"></li>
													<li style="background-color: #D8D8A8"></li>
													<li style="background-color: #FF6699"></li>
													<li style="background-color: #FA5B49"></li>
													<li style="background-color: #9FC2D6"></li>
													<li style="background-color: #549CCC"></li>
													<li style="background-color: #F0D8D8"></li>
													<li style="background-color: #6991AA"></li>
													<li style="background-color: #D4E77D"></li>
													<li style="background-color: #62BECB"></li>
													<li style="background-color: #7D96FF"></li>
													<li style="background-color: #F9FAD2"></li>
													<li style="background-color: #F5FAAC"></li>
													<li style="background-color: #FFAA7D"></li>
													<li style="background-color: #786060"></li>
													<li style="background-color: #A8A878"></li>
													<li style="background-color: #48A09B"></li>
													<li style="background-color: #FFF200"></li>
													<li style="background-color: #FCCD43"></li>
													<li style="background-color: #83AF9B"></li>
													<li style="background-color: #E1F5B0"></li>
													<li style="background-color: #C7E7E6"></li>
													<li style="background-color: #FFBAA9"></li>
												</ul>
EOT;
	
		return $color_picker_markup;
	}
	
	//generate pattern picker boxes
	function get_pattern_picker_markup(){
		$pattern_picker_markup =<<<EOT
												<ul class="et_pattern_picker">
													<li data-pattern="pattern_001.gif" style="background-image: url('images/form_resources/pattern_001.gif');"></li>
													<li data-pattern="pattern_002.gif" style="background-image: url('images/form_resources/pattern_002.gif');"></li>
													<li data-pattern="pattern_003.gif" style="background-image: url('images/form_resources/pattern_003.gif');"></li>
													<li data-pattern="pattern_004.gif" style="background-image: url('images/form_resources/pattern_004.gif');"></li>
													<li data-pattern="pattern_005.gif" style="background-image: url('images/form_resources/pattern_005.gif');"></li>
													<li data-pattern="pattern_006.gif" style="background-image: url('images/form_resources/pattern_006.gif');"></li>
													<li data-pattern="pattern_007.gif" style="background-image: url('images/form_resources/pattern_007.gif');"></li>
													<li data-pattern="pattern_008.gif" style="background-image: url('images/form_resources/pattern_008.gif');"></li>
													<li data-pattern="pattern_009.gif" style="background-image: url('images/form_resources/pattern_009.gif');"></li>
													<li data-pattern="pattern_010.gif" style="background-image: url('images/form_resources/pattern_010.gif');"></li>
													<li data-pattern="pattern_011.gif" style="background-image: url('images/form_resources/pattern_011.gif');"></li>
													<li data-pattern="pattern_012.gif" style="background-image: url('images/form_resources/pattern_012.gif');"></li>
													<li data-pattern="pattern_013.gif" style="background-image: url('images/form_resources/pattern_013.gif');"></li>
													<li data-pattern="pattern_014.gif" style="background-image: url('images/form_resources/pattern_014.gif');"></li>
													<li data-pattern="pattern_015.gif" style="background-image: url('images/form_resources/pattern_015.gif');"></li>
													<li data-pattern="pattern_016.gif" style="background-image: url('images/form_resources/pattern_016.gif');"></li>
													<li data-pattern="pattern_017.gif" style="background-image: url('images/form_resources/pattern_017.gif');"></li>
													<li data-pattern="pattern_018.gif" style="background-image: url('images/form_resources/pattern_018.gif');"></li>
													<li data-pattern="pattern_019.gif" style="background-image: url('images/form_resources/pattern_019.gif');"></li>
													<li data-pattern="pattern_020.gif" style="background-image: url('images/form_resources/pattern_020.gif');"></li>
													<li data-pattern="pattern_021.gif" style="background-image: url('images/form_resources/pattern_021.gif');"></li>
													<li data-pattern="pattern_022.gif" style="background-image: url('images/form_resources/pattern_022.gif');"></li>
													<li data-pattern="pattern_023.gif" style="background-image: url('images/form_resources/pattern_023.gif');"></li>
													<li data-pattern="pattern_024.gif" style="background-image: url('images/form_resources/pattern_024.gif');"></li>
													<li data-pattern="pattern_025.gif" style="background-image: url('images/form_resources/pattern_025.gif');"></li>
													<li data-pattern="pattern_026.gif" style="background-image: url('images/form_resources/pattern_026.gif');"></li>
													<li data-pattern="pattern_027.gif" style="background-image: url('images/form_resources/pattern_027.gif');"></li>
													<li data-pattern="pattern_028.gif" style="background-image: url('images/form_resources/pattern_028.gif');"></li>
													<li data-pattern="pattern_029.gif" style="background-image: url('images/form_resources/pattern_029.gif');"></li>
													<li data-pattern="pattern_030.gif" style="background-image: url('images/form_resources/pattern_030.gif');"></li>
													<li data-pattern="pattern_031.gif" style="background-image: url('images/form_resources/pattern_031.gif');"></li>
													<li data-pattern="pattern_032.gif" style="background-image: url('images/form_resources/pattern_032.gif');"></li>
													<li data-pattern="pattern_033.gif" style="background-image: url('images/form_resources/pattern_033.gif');"></li>
													<li data-pattern="pattern_034.gif" style="background-image: url('images/form_resources/pattern_034.gif');"></li>
													<li data-pattern="pattern_035.gif" style="background-image: url('images/form_resources/pattern_035.gif');"></li>
													<li data-pattern="pattern_036.gif" style="background-image: url('images/form_resources/pattern_036.gif');"></li>
													<li data-pattern="pattern_037.gif" style="background-image: url('images/form_resources/pattern_037.gif');"></li>
													<li data-pattern="pattern_038.gif" style="background-image: url('images/form_resources/pattern_038.gif');"></li>
													<li data-pattern="pattern_039.gif" style="background-image: url('images/form_resources/pattern_039.gif');"></li>
													<li data-pattern="pattern_040.gif" style="background-image: url('images/form_resources/pattern_040.gif');"></li>
													<li data-pattern="pattern_041.gif" style="background-image: url('images/form_resources/pattern_041.gif');"></li>
													<li data-pattern="pattern_042.gif" style="background-image: url('images/form_resources/pattern_042.gif');"></li>
													<li data-pattern="pattern_043.gif" style="background-image: url('images/form_resources/pattern_043.gif');"></li>
													<li data-pattern="pattern_044.gif" style="background-image: url('images/form_resources/pattern_044.gif');"></li>
													<li data-pattern="pattern_045.gif" style="background-image: url('images/form_resources/pattern_045.gif');"></li>
													<li data-pattern="pattern_046.gif" style="background-image: url('images/form_resources/pattern_046.gif');"></li>
													<li data-pattern="pattern_047.gif" style="background-image: url('images/form_resources/pattern_047.gif');"></li>
													<li data-pattern="pattern_048.gif" style="background-image: url('images/form_resources/pattern_048.gif');"></li>
													<li data-pattern="pattern_049.gif" style="background-image: url('images/form_resources/pattern_049.gif');"></li>
													<li data-pattern="pattern_050.gif" style="background-image: url('images/form_resources/pattern_050.gif');"></li>
													<li data-pattern="pattern_051.gif" style="background-image: url('images/form_resources/pattern_051.gif');"></li>
													<li data-pattern="pattern_052.gif" style="background-image: url('images/form_resources/pattern_052.gif');"></li>
													<li data-pattern="pattern_053.gif" style="background-image: url('images/form_resources/pattern_053.gif');"></li>
													<li data-pattern="pattern_054.gif" style="background-image: url('images/form_resources/pattern_054.gif');"></li>
													<li data-pattern="pattern_055.gif" style="background-image: url('images/form_resources/pattern_055.gif');"></li>
													<li data-pattern="pattern_056.gif" style="background-image: url('images/form_resources/pattern_056.gif');"></li>
													<li data-pattern="pattern_057.gif" style="background-image: url('images/form_resources/pattern_057.gif');"></li>
													<li data-pattern="pattern_058.gif" style="background-image: url('images/form_resources/pattern_058.gif');"></li>
													<li data-pattern="pattern_059.gif" style="background-image: url('images/form_resources/pattern_059.gif');"></li>
													<li data-pattern="pattern_060.gif" style="background-image: url('images/form_resources/pattern_060.gif');"></li>
													<li data-pattern="pattern_061.gif" style="background-image: url('images/form_resources/pattern_061.gif');"></li>
													<li data-pattern="pattern_062.gif" style="background-image: url('images/form_resources/pattern_062.gif');"></li>
													<li data-pattern="pattern_063.gif" style="background-image: url('images/form_resources/pattern_063.gif');"></li>
													<li data-pattern="pattern_064.gif" style="background-image: url('images/form_resources/pattern_064.gif');"></li>
													<li data-pattern="pattern_065.gif" style="background-image: url('images/form_resources/pattern_065.gif');"></li>
													<li data-pattern="pattern_066.gif" style="background-image: url('images/form_resources/pattern_066.gif');"></li>
													<li data-pattern="pattern_067.gif" style="background-image: url('images/form_resources/pattern_067.gif');"></li>
													<li data-pattern="pattern_068.gif" style="background-image: url('images/form_resources/pattern_068.gif');"></li>
													<li data-pattern="pattern_069.gif" style="background-image: url('images/form_resources/pattern_069.gif');"></li>
													<li data-pattern="pattern_070.gif" style="background-image: url('images/form_resources/pattern_070.gif');"></li>
													<li data-pattern="pattern_071.gif" style="background-image: url('images/form_resources/pattern_071.gif');"></li>
													<li data-pattern="pattern_072.gif" style="background-image: url('images/form_resources/pattern_072.gif');"></li>
													<li data-pattern="pattern_073.gif" style="background-image: url('images/form_resources/pattern_073.gif');"></li>
													<li data-pattern="pattern_074.gif" style="background-image: url('images/form_resources/pattern_074.gif');"></li>
													<li data-pattern="pattern_075.gif" style="background-image: url('images/form_resources/pattern_075.gif');"></li>
													<li data-pattern="pattern_076.gif" style="background-image: url('images/form_resources/pattern_076.gif');"></li>
													<li data-pattern="pattern_077.gif" style="background-image: url('images/form_resources/pattern_077.gif');"></li>
													<li data-pattern="pattern_078.gif" style="background-image: url('images/form_resources/pattern_078.gif');"></li>
													<li data-pattern="pattern_079.gif" style="background-image: url('images/form_resources/pattern_079.gif');"></li>
													<li data-pattern="pattern_080.gif" style="background-image: url('images/form_resources/pattern_080.gif');"></li>
													<li data-pattern="pattern_081.gif" style="background-image: url('images/form_resources/pattern_081.gif');"></li>
													<li data-pattern="pattern_082.gif" style="background-image: url('images/form_resources/pattern_082.gif');"></li>
													<li data-pattern="pattern_083.gif" style="background-image: url('images/form_resources/pattern_083.gif');"></li>
													<li data-pattern="pattern_084.gif" style="background-image: url('images/form_resources/pattern_084.gif');"></li>
													<li data-pattern="pattern_085.gif" style="background-image: url('images/form_resources/pattern_085.gif');"></li>
													<li data-pattern="pattern_086.gif" style="background-image: url('images/form_resources/pattern_086.gif');"></li>
													<li data-pattern="pattern_087.gif" style="background-image: url('images/form_resources/pattern_087.gif');"></li>
													<li data-pattern="pattern_088.gif" style="background-image: url('images/form_resources/pattern_088.gif');"></li>
													<li data-pattern="pattern_089.gif" style="background-image: url('images/form_resources/pattern_089.gif');"></li>
													<li data-pattern="pattern_090.gif" style="background-image: url('images/form_resources/pattern_090.gif');"></li>
													<li data-pattern="pattern_091.gif" style="background-image: url('images/form_resources/pattern_091.gif');"></li>
													<li data-pattern="pattern_092.gif" style="background-image: url('images/form_resources/pattern_092.gif');"></li>
													<li data-pattern="pattern_093.gif" style="background-image: url('images/form_resources/pattern_093.gif');"></li>
													<li data-pattern="pattern_094.gif" style="background-image: url('images/form_resources/pattern_094.gif');"></li>
													<li data-pattern="pattern_095.gif" style="background-image: url('images/form_resources/pattern_095.gif');"></li>
													<li data-pattern="pattern_096.gif" style="background-image: url('images/form_resources/pattern_096.gif');"></li>
													<li data-pattern="pattern_097.gif" style="background-image: url('images/form_resources/pattern_097.gif');"></li>
													<li data-pattern="pattern_098.gif" style="background-image: url('images/form_resources/pattern_098.gif');"></li>
													<li data-pattern="pattern_099.gif" style="background-image: url('images/form_resources/pattern_099.gif');"></li>
													<li data-pattern="pattern_100.gif" style="background-image: url('images/form_resources/pattern_100.gif');"></li>
													<li data-pattern="pattern_101.gif" style="background-image: url('images/form_resources/pattern_101.gif');"></li>
													<li data-pattern="pattern_102.gif" style="background-image: url('images/form_resources/pattern_102.gif');"></li>
													<li data-pattern="pattern_103.gif" style="background-image: url('images/form_resources/pattern_103.gif');"></li>
													<li data-pattern="pattern_104.gif" style="background-image: url('images/form_resources/pattern_104.gif');"></li>
													<li data-pattern="pattern_105.gif" style="background-image: url('images/form_resources/pattern_105.gif');"></li>
													<li data-pattern="pattern_106.gif" style="background-image: url('images/form_resources/pattern_106.gif');"></li>
													<li data-pattern="pattern_107.gif" style="background-image: url('images/form_resources/pattern_107.gif');"></li>
													<li data-pattern="pattern_108.gif" style="background-image: url('images/form_resources/pattern_108.gif');"></li>
													<li data-pattern="pattern_109.gif" style="background-image: url('images/form_resources/pattern_109.gif');"></li>
													<li data-pattern="pattern_110.gif" style="background-image: url('images/form_resources/pattern_110.gif');"></li>
													<li data-pattern="pattern_111.gif" style="background-image: url('images/form_resources/pattern_111.gif');"></li>
													<li data-pattern="pattern_112.gif" style="background-image: url('images/form_resources/pattern_112.gif');"></li>
													<li data-pattern="pattern_113.gif" style="background-image: url('images/form_resources/pattern_113.gif');"></li>
													<li data-pattern="pattern_114.gif" style="background-image: url('images/form_resources/pattern_114.gif');"></li>
													<li data-pattern="pattern_115.gif" style="background-image: url('images/form_resources/pattern_115.gif');"></li>
													<li data-pattern="pattern_116.gif" style="background-image: url('images/form_resources/pattern_116.gif');"></li>
													<li data-pattern="pattern_117.gif" style="background-image: url('images/form_resources/pattern_117.gif');"></li>
													<li data-pattern="pattern_118.gif" style="background-image: url('images/form_resources/pattern_118.gif');"></li>
													<li data-pattern="pattern_119.gif" style="background-image: url('images/form_resources/pattern_119.gif');"></li>
													<li data-pattern="pattern_120.gif" style="background-image: url('images/form_resources/pattern_120.gif');"></li>
													<li data-pattern="pattern_121.gif" style="background-image: url('images/form_resources/pattern_121.gif');"></li>
													<li data-pattern="pattern_122.gif" style="background-image: url('images/form_resources/pattern_122.gif');"></li>
													<li data-pattern="pattern_123.gif" style="background-image: url('images/form_resources/pattern_123.gif');"></li>
													<li data-pattern="pattern_124.gif" style="background-image: url('images/form_resources/pattern_124.gif');"></li>
													<li data-pattern="pattern_125.gif" style="background-image: url('images/form_resources/pattern_125.gif');"></li>
													<li data-pattern="pattern_126.gif" style="background-image: url('images/form_resources/pattern_126.gif');"></li>
													<li data-pattern="pattern_127.gif" style="background-image: url('images/form_resources/pattern_127.gif');"></li>
													<li data-pattern="pattern_128.gif" style="background-image: url('images/form_resources/pattern_128.gif');"></li>
													<li data-pattern="pattern_129.gif" style="background-image: url('images/form_resources/pattern_129.gif');"></li>
													<li data-pattern="pattern_130.gif" style="background-image: url('images/form_resources/pattern_130.gif');"></li>
													<li data-pattern="pattern_131.gif" style="background-image: url('images/form_resources/pattern_131.gif');"></li>
													<li data-pattern="pattern_132.gif" style="background-image: url('images/form_resources/pattern_132.gif');"></li>
													<li data-pattern="pattern_133.gif" style="background-image: url('images/form_resources/pattern_133.gif');"></li>
													<li data-pattern="pattern_134.gif" style="background-image: url('images/form_resources/pattern_134.gif');"></li>
													<li data-pattern="pattern_135.gif" style="background-image: url('images/form_resources/pattern_135.gif');"></li>
													<li data-pattern="pattern_136.gif" style="background-image: url('images/form_resources/pattern_136.gif');"></li>
													<li data-pattern="pattern_137.gif" style="background-image: url('images/form_resources/pattern_137.gif');"></li>
													<li data-pattern="pattern_138.gif" style="background-image: url('images/form_resources/pattern_138.gif');"></li>
													<li data-pattern="pattern_139.gif" style="background-image: url('images/form_resources/pattern_139.gif');"></li>
													<li data-pattern="pattern_140.gif" style="background-image: url('images/form_resources/pattern_140.gif');"></li>
													<li data-pattern="pattern_141.gif" style="background-image: url('images/form_resources/pattern_141.gif');"></li>
													<li data-pattern="pattern_142.gif" style="background-image: url('images/form_resources/pattern_142.gif');"></li>
													<li data-pattern="pattern_143.gif" style="background-image: url('images/form_resources/pattern_143.gif');"></li>
													<li data-pattern="pattern_144.gif" style="background-image: url('images/form_resources/pattern_144.gif');"></li>
													<li data-pattern="pattern_145.gif" style="background-image: url('images/form_resources/pattern_145.gif');"></li>
													<li data-pattern="pattern_146.gif" style="background-image: url('images/form_resources/pattern_146.gif');"></li>
													<li data-pattern="pattern_147.gif" style="background-image: url('images/form_resources/pattern_147.gif');"></li>
													<li data-pattern="pattern_148.gif" style="background-image: url('images/form_resources/pattern_148.gif');"></li>
													<li data-pattern="pattern_149.gif" style="background-image: url('images/form_resources/pattern_149.gif');"></li>
													<li data-pattern="pattern_150.gif" style="background-image: url('images/form_resources/pattern_150.gif');"></li>
													<li data-pattern="pattern_151.gif" style="background-image: url('images/form_resources/pattern_151.gif');"></li>
													<li data-pattern="pattern_152.gif" style="background-image: url('images/form_resources/pattern_152.gif');"></li>
													<li data-pattern="pattern_153.gif" style="background-image: url('images/form_resources/pattern_153.gif');"></li>
													<li data-pattern="pattern_154.gif" style="background-image: url('images/form_resources/pattern_154.gif');"></li>
													<li data-pattern="pattern_155.gif" style="background-image: url('images/form_resources/pattern_155.gif');"></li>
													<li data-pattern="pattern_156.gif" style="background-image: url('images/form_resources/pattern_156.gif');"></li>
													<li data-pattern="pattern_157.gif" style="background-image: url('images/form_resources/pattern_157.gif');"></li>
													<li data-pattern="pattern_158.gif" style="background-image: url('images/form_resources/pattern_158.gif');"></li>
												</ul>
EOT;
	
		return $pattern_picker_markup;
	}
	
	//generate font picker boxes
	function get_font_picker_markup(){
		$font_picker_markup =<<<EOT
												<ul class="et_font_picker">
													<li>
														<div class="font_picker_preview" style="font-family: 'Lucida Grande',sans-serif">Default</div>
														<div class="font_picker_meta">
															<div class="font_name">Lucida Grande</div>
															<div class="font_info">System Font</div>
														</div>
													</li>
													<li>
														<div id="li_lobster" class="font_picker_preview" style="font-family: Arial,sans-serif">Arial</div>
														<div class="font_picker_meta">
															<div class="font_name">Arial</div>
															<div class="font_info">System Font</div>
														</div>
													</li>
													<li>
														<div class="font_picker_preview" style="font-family: 'Trebuchet MS', Helvetica, sans-serif;">Trebuchet MS</div>
														<div class="font_picker_meta">
															<div class="font_name">Trebuchet MS</div>
															<div class="font_info">System Font</div>
														</div>
													</li>
													<li>
														<div class="font_picker_preview" style="font-family: Verdana, sans-serif;">Verdana</div>
														<div class="font_picker_meta">
															<div class="font_name">Verdana</div>
															<div class="font_info">System Font</div>
														</div>
													</li>
													<li>
														<div class="font_picker_preview" style="font-family: Tahoma, Geneva, sans-serif;">Tahoma</div>
														<div class="font_picker_meta">
															<div class="font_name">Tahoma</div>
															<div class="font_info">System Font</div>
														</div>
													</li>
													<li>
														<div class="font_picker_preview" style="font-family: 'Courier New', Courier, monospace;">Courier New</div>
														<div class="font_picker_meta">
															<div class="font_name">Courier New</div>
															<div class="font_info">System Font</div>
														</div>
													</li>
													<li>
														<div class="font_picker_preview" style="font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif;">Palatino Linotype</div>
														<div class="font_picker_meta">
															<div class="font_name">Palatino Linotype</div>
															<div class="font_info">System Font</div>
														</div>
													</li>
													<li>
														<div class="font_picker_preview" style="font-family: 'Times New Roman', serif;">Times New Roman</div>
														<div class="font_picker_meta">
															<div class="font_name">Times New Roman</div>
															<div class="font_info">System Font</div>
														</div>
													</li>
													<li>
														<div class="font_picker_preview" style="font-family: Georgia, serif;">Georgia</div>
														<div class="font_picker_meta">
															<div class="font_name">Georgia</div>
															<div class="font_info">System Font</div>
														</div>
													</li>
													<li>
														<div class="font_picker_preview" style="font-family: 'Comic Sans MS', cursive;">Comic Sans MS</div>
														<div class="font_picker_meta">
															<div class="font_name">Comic Sans MS</div>
															<div class="font_info">System Font</div>
														</div>
													</li>
													<li>
														<div class="font_picker_preview" style="font-family: 'Arial Black', Gadget, sans-serif;">Arial Black</div>
														<div class="font_picker_meta">
															<div class="font_name">Arial Black</div>
															<div class="font_info">System Font</div>
														</div>
													</li>
													<li class="li_show_more">
														<span>Show More Fonts</span> <img src="images/icons/arrow_down.png" style="vertical-align: middle"/>
													</li>
												</ul>
EOT;
	
		return $font_picker_markup;
	}
	
	//generate the CSS markup for the selected form theme
	function mf_theme_get_css_content($dbh,$theme_id){
		
		$css_content = "/** DO NOT MODIFY THIS FILE. All code here are generated by MachForm Theme Editor **/\n\n";
		$theme_properties = new stdClass();
		
		$mf_settings = mf_get_settings($dbh);

		$ssl_suffix = mf_get_ssl_suffix();
		if(!empty($ssl_suffix)){
			$mf_settings['base_url'] = str_replace('http', 'https', $mf_settings['base_url']);
		}
		
		$query = "SELECT
						theme_name,
						logo_type,
						ifnull(logo_custom_image,'') logo_custom_image,
						logo_custom_height,
						logo_default_image,
						wallpaper_bg_type,
						wallpaper_bg_color,
						wallpaper_bg_pattern,
						wallpaper_bg_custom,
						header_bg_type,
						header_bg_color,
						header_bg_pattern,
						header_bg_custom,
						form_bg_type,
						form_bg_color,
						form_bg_pattern,
						form_bg_custom,
						highlight_bg_type,
						highlight_bg_color,
						highlight_bg_pattern,
						highlight_bg_custom,
						guidelines_bg_type,
						guidelines_bg_color,
						guidelines_bg_pattern,
						guidelines_bg_custom,
						field_bg_type,
						field_bg_color,
						field_bg_pattern,
						field_bg_custom,
						form_title_font_type,
						form_title_font_weight,
						form_title_font_style,
						form_title_font_size,
						form_title_font_color,
						form_desc_font_type,
						form_desc_font_weight,
						form_desc_font_style,
						form_desc_font_size,
						form_desc_font_color,
						field_title_font_type,
						field_title_font_weight,
						field_title_font_style,
						field_title_font_size,
						field_title_font_color,
						guidelines_font_type,
						guidelines_font_weight,
						guidelines_font_style,
						guidelines_font_size,
						guidelines_font_color,
						section_title_font_type,
						section_title_font_weight,
						section_title_font_style,
						section_title_font_size,
						section_title_font_color,
						section_desc_font_type,
						section_desc_font_weight,
						section_desc_font_style,
						section_desc_font_size,
						section_desc_font_color,
						field_text_font_type,
						field_text_font_weight,
						field_text_font_style,
						field_text_font_size,
						field_text_font_color,
						border_form_width,
						border_form_style,
						border_form_color,
						border_guidelines_width,
						border_guidelines_style,
						border_guidelines_color,
						border_section_width,
						border_section_style,
						border_section_color,
						form_shadow_style,
						form_shadow_size,
						form_shadow_brightness,
						form_button_type,
						form_button_text,
						form_button_image,
						advanced_css
					FROM
						`".MF_TABLE_PREFIX."form_themes`
				   WHERE
				   		theme_id=? and `status`=1";
		$params = array($theme_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);
		
		$theme_properties->theme_id 		   = $theme_id;
		$theme_properties->theme_name  		   = $row['theme_name'];
		$theme_properties->logo_type 		   = $row['logo_type']; 
		$theme_properties->logo_custom_image   = $row['logo_custom_image'];
		$theme_properties->logo_custom_height  = (int) $row['logo_custom_height'];
		$theme_properties->logo_default_image  = $row['logo_default_image'];
		$theme_properties->wallpaper_bg_type 	= $row['wallpaper_bg_type'];
		$theme_properties->wallpaper_bg_color 	= $row['wallpaper_bg_color'];
		$theme_properties->wallpaper_bg_pattern = $row['wallpaper_bg_pattern'];
		$theme_properties->wallpaper_bg_custom 	= $row['wallpaper_bg_custom'];
		$theme_properties->header_bg_type 		= $row['header_bg_type'];
		$theme_properties->header_bg_color 		= $row['header_bg_color'];
		$theme_properties->header_bg_pattern 	= $row['header_bg_pattern'];;
		$theme_properties->header_bg_custom 	= $row['header_bg_custom'];
		$theme_properties->form_bg_type 		= $row['form_bg_type'];
		$theme_properties->form_bg_color 		= $row['form_bg_color'];
		$theme_properties->form_bg_pattern 		= $row['form_bg_pattern'];;
		$theme_properties->form_bg_custom 		= $row['form_bg_custom'];
		$theme_properties->highlight_bg_type 	= $row['highlight_bg_type'];
		$theme_properties->highlight_bg_color 	= $row['highlight_bg_color'];
		$theme_properties->highlight_bg_pattern = $row['highlight_bg_pattern'];
		$theme_properties->highlight_bg_custom 	= $row['highlight_bg_custom'];
		$theme_properties->guidelines_bg_type 	= $row['guidelines_bg_type'];
		$theme_properties->guidelines_bg_color 	= $row['guidelines_bg_color'];
		$theme_properties->guidelines_bg_pattern = $row['guidelines_bg_pattern'];
		$theme_properties->guidelines_bg_custom  = $row['guidelines_bg_custom'];
		$theme_properties->field_bg_type 		 = $row['field_bg_type'];
		$theme_properties->field_bg_color 		 = $row['field_bg_color'];
		$theme_properties->field_bg_pattern 	 = $row['field_bg_pattern'];
		$theme_properties->field_bg_custom  	 = $row['field_bg_custom'];
		$theme_properties->form_title_font_type    = $row['form_title_font_type'];
		$theme_properties->form_title_font_weight  = (int) $row['form_title_font_weight'];
		$theme_properties->form_title_font_style   = $row['form_title_font_style'];
		$theme_properties->form_title_font_size    = $row['form_title_font_size'];
		$theme_properties->form_title_font_color   = $row['form_title_font_color'];
		$theme_properties->form_desc_font_type    = $row['form_desc_font_type'];
		$theme_properties->form_desc_font_weight  = (int) $row['form_desc_font_weight'];
		$theme_properties->form_desc_font_style   = $row['form_desc_font_style'];
		$theme_properties->form_desc_font_size    = $row['form_desc_font_size'];
		$theme_properties->form_desc_font_color   = $row['form_desc_font_color'];
		$theme_properties->field_title_font_type    = $row['field_title_font_type'];
		$theme_properties->field_title_font_weight  = (int) $row['field_title_font_weight'];
		$theme_properties->field_title_font_style   = $row['field_title_font_style'];
		$theme_properties->field_title_font_size    = $row['field_title_font_size'];
		$theme_properties->field_title_font_color   = $row['field_title_font_color'];
		$theme_properties->guidelines_font_type    = $row['guidelines_font_type'];
		$theme_properties->guidelines_font_weight  = (int) $row['guidelines_font_weight'];
		$theme_properties->guidelines_font_style   = $row['guidelines_font_style'];
		$theme_properties->guidelines_font_size    = $row['guidelines_font_size'];
		$theme_properties->guidelines_font_color   = $row['guidelines_font_color'];
		$theme_properties->section_title_font_type    = $row['section_title_font_type'];
		$theme_properties->section_title_font_weight  = (int) $row['section_title_font_weight'];
		$theme_properties->section_title_font_style   = $row['section_title_font_style'];
		$theme_properties->section_title_font_size    = $row['section_title_font_size'];
		$theme_properties->section_title_font_color   = $row['section_title_font_color'];
		$theme_properties->section_desc_font_type    = $row['section_desc_font_type'];
		$theme_properties->section_desc_font_weight  = (int) $row['section_desc_font_weight'];
		$theme_properties->section_desc_font_style   = $row['section_desc_font_style'];
		$theme_properties->section_desc_font_size    = $row['section_desc_font_size'];
		$theme_properties->section_desc_font_color   = $row['section_desc_font_color'];
		$theme_properties->field_text_font_type    = $row['field_text_font_type'];
		$theme_properties->field_text_font_weight  = (int) $row['field_text_font_weight'];
		$theme_properties->field_text_font_style   = $row['field_text_font_style'];
		$theme_properties->field_text_font_size    = $row['field_text_font_size'];
		$theme_properties->field_text_font_color   = $row['field_text_font_color'];
		$theme_properties->border_form_width   = (int) $row['border_form_width'];
		$theme_properties->border_form_style   = $row['border_form_style'];
		$theme_properties->border_form_color   = $row['border_form_color'];
		$theme_properties->border_guidelines_width   = (int) $row['border_guidelines_width'];
		$theme_properties->border_guidelines_style   = $row['border_guidelines_style'];
		$theme_properties->border_guidelines_color   = $row['border_guidelines_color'];
		$theme_properties->border_section_width   = (int) $row['border_section_width'];
		$theme_properties->border_section_style   = $row['border_section_style'];
		$theme_properties->border_section_color   = $row['border_section_color'];
		$theme_properties->form_shadow_style	  = $row['form_shadow_style'];
		$theme_properties->form_shadow_size	  	  = $row['form_shadow_size'];
		$theme_properties->form_shadow_brightness = $row['form_shadow_brightness'];
		$theme_properties->form_button_type	  	  = $row['form_button_type'];
		$theme_properties->form_button_text	  	  = $row['form_button_text'];
		$theme_properties->form_button_image	  = $row['form_button_image'];
		$theme_properties->advanced_css	  		  = $row['advanced_css'];
		
		/** Form Logo **/
		$form_logo_style  = "#main_body h1 a";
		$form_logo_style .= "\n"."{"."\n";
		
		$form_logo_height = 40;
		
		if($theme_properties->logo_type == 'disabled'){ //logo disabled
			$form_logo_style .= "background-image: none;"."\n";
		}else if($theme_properties->logo_type == 'default'){//default logo
			$form_logo_style .= "background-image: url('{$mf_settings['base_url']}images/form_resources/{$theme_properties->logo_default_image}');"."\n";
			$form_logo_style .= "background-repeat: no-repeat;"."\n";
		}else if($theme_properties->logo_type == 'custom'){//custom logo
			$form_logo_style .= "background-image: url('{$theme_properties->logo_custom_image}');"."\n";
			$form_logo_height  = $theme_properties->logo_custom_height;
		}
		
		$form_logo_style .= "height: {$form_logo_height}px;"."\n";
		$form_logo_style .= "}"."\n\n";
		
		$css_content .= $form_logo_style;
		
		/** Wallpaper **/
		$form_wallpaper_style = "html";
		$form_wallpaper_style .= "\n"."{"."\n";
		
		if($theme_properties->wallpaper_bg_type == 'color'){
			$form_wallpaper_style .= "background-color: {$theme_properties->wallpaper_bg_color};"."\n";
		}else if($theme_properties->wallpaper_bg_type == 'pattern'){
			$form_wallpaper_style .= "background-image: url('{$mf_settings['base_url']}images/form_resources/{$theme_properties->wallpaper_bg_pattern}');"."\n";
			$form_wallpaper_style .= "background-repeat: repeat;"."\n";
		}else if($theme_properties->wallpaper_bg_type == 'custom'){
			$form_wallpaper_style .= "background-image: url('{$theme_properties->wallpaper_bg_custom}');"."\n";
			$form_wallpaper_style .= "background-repeat: repeat;"."\n";
		}
		
		$form_wallpaper_style .= "}"."\n\n";
		$css_content .= $form_wallpaper_style;
		
		/** Form Header **/
		$form_header_style = "#main_body h1";
		$form_header_style .= "\n"."{"."\n";
		
		if($theme_properties->header_bg_type == 'color'){
			$form_header_style .= "background-color: {$theme_properties->header_bg_color};"."\n";
		}else if($theme_properties->header_bg_type == 'pattern'){
			$form_header_style .= "background-image: url('{$mf_settings['base_url']}images/form_resources/{$theme_properties->header_bg_pattern}');"."\n";
			$form_header_style .= "background-repeat: repeat;"."\n";
		}else if($theme_properties->header_bg_type == 'custom'){
			$form_header_style .= "background-image: url('{$theme_properties->header_bg_custom}');"."\n";
			$form_header_style .= "background-repeat: repeat;"."\n";
		}
		
		$form_header_style .= "}"."\n\n";
		$css_content .= $form_header_style;
		
		/** Form Background **/
		$form_container_style = "#form_container";
		$form_container_style .= "\n"."{"."\n";
		
		if($theme_properties->form_bg_type == 'color'){
			$form_container_style .= "background-color: {$theme_properties->form_bg_color};"."\n";
		}else if($theme_properties->form_bg_type == 'pattern'){
			$form_container_style .= "background-image: url('{$mf_settings['base_url']}images/form_resources/{$theme_properties->form_bg_pattern}');"."\n";
			$form_container_style .= "background-repeat: repeat;"."\n";
		}else if($theme_properties->form_bg_type == 'custom'){
			$form_container_style .= "background-image: url('{$theme_properties->form_bg_custom}');"."\n";
			$form_container_style .= "background-repeat: repeat;"."\n";
		}
		
		/** Form Border **/
		if(!empty($theme_properties->border_form_width)){
			$form_container_style .= "border-width: {$theme_properties->border_form_width}px;"."\n";
		}else{
			$form_container_style .= "border-width: 0px;"."\n";
		}
		
		if(!empty($theme_properties->border_form_style)){
			$form_container_style .= "border-style: {$theme_properties->border_form_style};"."\n";
		}
		
		if(!empty($theme_properties->border_form_color)){
			$form_container_style .= "border-color: {$theme_properties->border_form_color};"."\n";
		}
		
		$form_container_style .= "}"."\n\n";
		$css_content .= $form_container_style;
		
		/** Field Highlight **/
		$field_highlight_style = "#main_body form li.highlighted,#main_body .matrix tbody tr:hover td,#machform_review_table tr.alt";
		$field_highlight_style .= "\n"."{"."\n";
		
		if($theme_properties->highlight_bg_type == 'color'){
			$field_highlight_style .= "background-color: {$theme_properties->highlight_bg_color};"."\n";
		}else if($theme_properties->highlight_bg_type == 'pattern'){
			$field_highlight_style .= "background-image: url('{$mf_settings['base_url']}images/form_resources/{$theme_properties->highlight_bg_pattern}');"."\n";
			$field_highlight_style .= "background-repeat: repeat;"."\n";
		}else if($theme_properties->highlight_bg_type == 'custom'){
			$field_highlight_style .= "background-image: url('{$theme_properties->highlight_bg_custom}');"."\n";
			$field_highlight_style .= "background-repeat: repeat;"."\n";
		}
		
		$field_highlight_style .= "}"."\n\n";
		$css_content .= $field_highlight_style;
		
		/** Field Guidelines **/
		$field_guidelines_style = "#main_body form .guidelines";
		$field_guidelines_style .= "\n"."{"."\n";
		
		if($theme_properties->guidelines_bg_type == 'color'){
			$field_guidelines_style .= "background-color: {$theme_properties->guidelines_bg_color};"."\n";
		}else if($theme_properties->guidelines_bg_type == 'pattern'){
			$field_guidelines_style .= "background-image: url('{$mf_settings['base_url']}images/form_resources/{$theme_properties->guidelines_bg_pattern}');"."\n";
			$field_guidelines_style .= "background-repeat: repeat;"."\n";
		}else if($theme_properties->guidelines_bg_type == 'custom'){
			$field_guidelines_style .= "background-image: url('{$theme_properties->guidelines_bg_custom}');"."\n";
			$field_guidelines_style .= "background-repeat: repeat;"."\n";
		}
		
		//guidelines border
		if(!empty($theme_properties->border_guidelines_width)){
			$field_guidelines_style .= "border-width: {$theme_properties->border_guidelines_width}px;"."\n";
		}else{
			$field_guidelines_style .= "border-width: 0px;"."\n";
		}
		
		if(!empty($theme_properties->border_guidelines_style)){
			$field_guidelines_style .= "border-style: {$theme_properties->border_guidelines_style};"."\n";
		}
		
		if(!empty($theme_properties->border_guidelines_color)){
			$field_guidelines_style .= "border-color: {$theme_properties->border_guidelines_color};"."\n";
		}
		
		$field_guidelines_style .= "}"."\n\n";
		$css_content .= $field_guidelines_style;
		
		//guidelines font
		$field_guidelines_text_style = "#main_body form .guidelines small";
		$field_guidelines_text_style .= "\n"."{"."\n";
		
		if(!empty($theme_properties->guidelines_font_type)){
			$field_guidelines_text_style .= "font-family: '{$theme_properties->guidelines_font_type}','Lucida Grande',Tahoma,Arial,sans-serif;"."\n";
		}
		
		if(!empty($theme_properties->guidelines_font_weight)){
			$field_guidelines_text_style .= "font-weight: {$theme_properties->guidelines_font_weight};"."\n";
		}
		
		if(!empty($theme_properties->guidelines_font_style)){
			$field_guidelines_text_style .= "font-style: {$theme_properties->guidelines_font_style};"."\n";
		}
		
		if(!empty($theme_properties->guidelines_font_size)){
			$field_guidelines_text_style .= "font-size: {$theme_properties->guidelines_font_size};"."\n";
		}
		
		if(!empty($theme_properties->guidelines_font_color)){
			$field_guidelines_text_style .= "color: {$theme_properties->guidelines_font_color};"."\n";
		}
		
		$field_guidelines_text_style .= "}"."\n\n";
		$css_content .= $field_guidelines_text_style;
		
		
		/** Field Box **/
		$field_box_style = "#main_body input.text,#main_body input.file,#main_body textarea.textarea,#main_body select.select,#main_body input.checkbox,#main_body input.radio";
		$field_box_style .= "\n"."{"."\n";
		
		if($theme_properties->field_bg_type == 'color'){
			$field_box_style .= "background-color: {$theme_properties->field_bg_color};"."\n";
		}else if($theme_properties->field_bg_type == 'pattern'){
			$field_box_style .= "background-image: url('{$mf_settings['base_url']}images/form_resources/{$theme_properties->field_bg_pattern}');"."\n";
			$field_box_style .= "background-repeat: repeat;";
		}else if($theme_properties->field_bg_type == 'custom'){
			$field_box_style .= "background-image: url('{$theme_properties->field_bg_custom}');"."\n";
			$field_box_style .= "background-repeat: repeat;"."\n";
		}
		
		//field text values
		if(!empty($theme_properties->field_text_font_type)){
			$field_box_style .= "font-family: '{$theme_properties->field_text_font_type}','Lucida Grande',Tahoma,Arial,sans-serif;"."\n";
			$font_family_array .= $theme_properties->field_text_font_type;
		}
		
		if(!empty($theme_properties->field_text_font_weight)){
			$field_box_style .= "font-weight: {$theme_properties->field_text_font_weight};"."\n";
		}
		
		if(!empty($theme_properties->field_text_font_style)){
			$field_box_style .= "font-style: {$theme_properties->field_text_font_style};"."\n";
		}
		
		if(!empty($theme_properties->field_text_font_size)){
			$field_box_style .= "font-size: {$theme_properties->field_text_font_size};"."\n";
		}
		
		if(!empty($theme_properties->field_text_font_color)){
			$field_box_style .= "color: {$theme_properties->field_text_font_color};"."\n";
		}
		
		$field_box_style .= "}"."\n\n";
		$css_content .= $field_box_style;

		/** Review Table, value section (right column) **/
		//this is similar as field box above, except without background
		$review_table_value_style = "#machform_review_table td.mf_review_value";
		$review_table_value_style .= "\n"."{"."\n";

		if(!empty($theme_properties->field_text_font_type)){
			$review_table_value_style .= "font-family: '{$theme_properties->field_text_font_type}','Lucida Grande',Tahoma,Arial,sans-serif;"."\n";
		}
		
		if(!empty($theme_properties->field_text_font_weight)){
			$review_table_value_style .= "font-weight: {$theme_properties->field_text_font_weight};"."\n";
		}
		
		if(!empty($theme_properties->field_text_font_style)){
			$review_table_value_style .= "font-style: {$theme_properties->field_text_font_style};"."\n";
		}
		
		if(!empty($theme_properties->field_text_font_size)){
			$review_table_value_style .= "font-size: {$theme_properties->field_text_font_size};"."\n";
		}
		
		if(!empty($theme_properties->field_text_font_color)){
			$review_table_value_style .= "color: {$theme_properties->field_text_font_color};"."\n";
		}

		$review_table_value_style .= "}"."\n\n";
		$css_content .= $review_table_value_style;
		
		/** Form Title **/
		$form_title_style = "#main_body .form_description h2,#main_body .form_success h2";
		$form_title_style .= "\n"."{"."\n";
		
		if(!empty($theme_properties->form_title_font_type)){
			$form_title_style .= "font-family: '{$theme_properties->form_title_font_type}','Lucida Grande',Tahoma,Arial,sans-serif;"."\n";
		}
		
		if(!empty($theme_properties->form_title_font_weight)){
			$form_title_style .= "font-weight: {$theme_properties->form_title_font_weight};"."\n";
		}
		
		if(!empty($theme_properties->form_title_font_style)){
			$form_title_style .= "font-style: {$theme_properties->form_title_font_style};"."\n";
		}
		
		if(!empty($theme_properties->form_title_font_size)){
			$form_title_style .= "font-size: {$theme_properties->form_title_font_size};"."\n";
		}
		
		if(!empty($theme_properties->form_title_font_color)){
			$form_title_style .= "color: {$theme_properties->form_title_font_color};"."\n";
		}
		
		$form_title_style .= "}"."\n\n";
		$css_content .= $form_title_style;
		
		/** Form Description **/
		$form_desc_style = "#main_body .form_description p";
		$form_desc_style .= "\n"."{"."\n";
		
		if(!empty($theme_properties->form_desc_font_type)){
			$form_desc_style .= "font-family: '{$theme_properties->form_desc_font_type}','Lucida Grande',Tahoma,Arial,sans-serif;"."\n";
		}
		
		if(!empty($theme_properties->form_desc_font_weight)){
			$form_desc_style .= "font-weight: {$theme_properties->form_desc_font_weight};"."\n";
		}
		
		if(!empty($theme_properties->form_desc_font_style)){
			$form_desc_style .= "font-style: {$theme_properties->form_desc_font_style};"."\n";
		}
		
		if(!empty($theme_properties->form_desc_font_size)){
			$form_desc_style .= "font-size: {$theme_properties->form_desc_font_size};"."\n";
		}
		
		if(!empty($theme_properties->form_desc_font_color)){
			$form_desc_style .= "color: {$theme_properties->form_desc_font_color};"."\n";
		}
		
		$form_desc_style .= "}"."\n\n";
		$css_content .= $form_desc_style;
		
		/** Field Title **/
		$field_title_style 	   = "#main_body label.description,#main_body .matrix caption,#main_body .matrix td.first_col,#main_body form li.total_payment span,#machform_review_table td.mf_review_label";
		$field_sub_title_style = "#main_body form li span label,#main_body label.choice,#main_body .matrix th,#main_body form li span.symbol";
		
		$field_title_style .= "\n"."{"."\n";
		$field_sub_title_style .= "\n"."{"."\n";
		
		if(!empty($theme_properties->field_title_font_type)){
			$field_title_style .= "font-family: '{$theme_properties->field_title_font_type}','Lucida Grande',Tahoma,Arial,sans-serif;"."\n";
			$field_sub_title_style .= "font-family: '{$theme_properties->field_title_font_type}','Lucida Grande',Tahoma,Arial,sans-serif;"."\n";
		}
		
		if(!empty($theme_properties->field_title_font_weight)){
			$field_title_style .= "font-weight: {$theme_properties->field_title_font_weight};"."\n";
		}
		
		if(!empty($theme_properties->field_title_font_style)){
			$field_title_style .= "font-style: {$theme_properties->field_title_font_style};"."\n";
		}
		
		if(!empty($theme_properties->field_title_font_size)){
			$field_title_style .= "font-size: {$theme_properties->field_title_font_size};"."\n";
		}
		
		if(!empty($theme_properties->field_title_font_color)){
			$field_title_style .= "color: {$theme_properties->field_title_font_color};"."\n";
			$field_sub_title_style .= "color: {$theme_properties->field_title_font_color};"."\n";
		}
		
		$field_title_style .= "}"."\n\n";
		$css_content .= $field_title_style;
		
		$field_sub_title_style .= "}"."\n\n";
		$css_content .= $field_sub_title_style;
		
		/** Section Title **/
		$section_title_style = "#main_body form .section_break h3";
		$section_title_style .= "\n"."{"."\n";
		
		if(!empty($theme_properties->section_title_font_type)){
			$section_title_style .= "font-family: '{$theme_properties->section_title_font_type}','Lucida Grande',Tahoma,Arial,sans-serif;"."\n";
		}
		
		if(!empty($theme_properties->section_title_font_weight)){
			$section_title_style .= "font-weight: {$theme_properties->section_title_font_weight};"."\n";
		}
		
		if(!empty($theme_properties->section_title_font_style)){
			$section_title_style .= "font-style: {$theme_properties->section_title_font_style};"."\n";
		}
		
		if(!empty($theme_properties->section_title_font_size)){
			$section_title_style .= "font-size: {$theme_properties->section_title_font_size};"."\n";
		}
		
		if(!empty($theme_properties->section_title_font_color)){
			$section_title_style .= "color: {$theme_properties->section_title_font_color};"."\n";
		}
		
		$section_title_style .= "}"."\n\n";
		$css_content .= $section_title_style;
		
		/** Section Description **/
		$section_desc_style = "#main_body form .section_break p";
		$section_desc_style .= "\n"."{"."\n";
		
		if(!empty($theme_properties->section_desc_font_type)){
			$section_desc_style .= "font-family: '{$theme_properties->section_desc_font_type}','Lucida Grande',Tahoma,Arial,sans-serif;"."\n";
		}
		
		if(!empty($theme_properties->section_desc_font_weight)){
			$section_desc_style .= "font-weight: {$theme_properties->section_desc_font_weight};"."\n";
		}
		
		if(!empty($theme_properties->section_desc_font_style)){
			$section_desc_style .= "font-style: {$theme_properties->section_desc_font_style};"."\n";
		}
		
		if(!empty($theme_properties->section_desc_font_size)){
			$section_desc_style .= "font-size: {$theme_properties->section_desc_font_size};"."\n";
		}
		
		if(!empty($theme_properties->section_desc_font_color)){
			$section_desc_style .= "color: {$theme_properties->section_desc_font_color};"."\n";
		}
		
		$section_desc_style .= "}"."\n\n";
		$css_content .= $section_desc_style;
		
		/** Section Block **/
		$section_block_style = "#main_body form li.section_break";
		$section_block_style .= "\n"."{"."\n";
		
		if(!empty($theme_properties->border_section_width)){
			$section_block_style .= "border-top-width: {$theme_properties->border_section_width}px;"."\n";
		}else{
			$section_block_style .= "border-top-width: 0px;"."\n";
		}
		
		if(!empty($theme_properties->border_section_style)){
			$section_block_style .= "border-top-style: {$theme_properties->border_section_style};"."\n";
		}
		
		if(!empty($theme_properties->border_section_color)){
			$section_block_style .= "border-top-color: {$theme_properties->border_section_color};"."\n";
		}
		
		$section_block_style .= "}"."\n\n";
		$css_content .= $section_block_style;
		
		/** Advanced CSS Code **/
		if(!empty($theme_properties->advanced_css)){
			$css_content .= "\n\n".'/** Advanced CSS **/'."\n\n";
			$css_content .= $theme_properties->advanced_css;
		}
		
		return $css_content;
		
	}
	
	//generate the links to the fonts
	function mf_theme_get_fonts_link($dbh,$theme_id){
		
		$font_family_array = array();
		
		$query = "SELECT
						form_title_font_type,
						form_desc_font_type,
						field_title_font_type,
						guidelines_font_type,
						section_title_font_type,
						section_desc_font_type,
						field_text_font_type
					FROM
						`".MF_TABLE_PREFIX."form_themes`
				   WHERE
				   		theme_id=? and `status`=1";
		$params = array($theme_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);
		
		$font_family_array[] = $row['form_title_font_type'];
		$font_family_array[] = $row['form_desc_font_type'];
		$font_family_array[] = $row['field_title_font_type'];
		$font_family_array[] = $row['guidelines_font_type'];
		$font_family_array[] = $row['section_title_font_type'];
		$font_family_array[] = $row['section_desc_font_type'];
		$font_family_array[] = $row['field_text_font_type'];
		
		/** Build the font CSS tag **/
		if(!empty($font_family_array)){
			$font_family_joined = implode("','",$font_family_array);
			
			$query = "SELECT font_family,font_variants FROM ".MF_TABLE_PREFIX."fonts WHERE font_family IN('{$font_family_joined}')";
			$params = array();
		
			$sth = mf_do_query($query,$params,$dbh);
			$font_css_array = array();
			while($row = mf_do_fetch_result($sth)){
				$font_css_array[] = urlencode($row['font_family']).":".$row['font_variants'];
			}
			
			$ssl_suffix = mf_get_ssl_suffix();

			$font_css_markup = implode('|',$font_css_array);
			if(!empty($font_css_array)){
				$font_css_markup = "<link href='http{$ssl_suffix}://fonts.googleapis.com/css?family={$font_css_markup}' rel='stylesheet' type='text/css'>\n";
			}else{
				$font_css_markup = '';
			}
		}
		
		return $font_css_markup;
	}
?>