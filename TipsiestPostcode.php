<?php
/*
 * Plugin Name: Tipsiest Postcode
 * Version: 1.06
 * Plugin URI: http://www.gartoo.net/widgets
 * Description: This will create a widget that shows how well does your uk postcode rank based on a number of criteria such as population, house prices, crime rate, etc.</a>.
 * Author: Gartoo - Lokku Labs 
 */
class TipsiestPostcode extends WP_Widget
{
  function activate(){
    $options = array( 'option1' => 'Default value' ,'option2' => 55);
    $data = file_get_contents(plugin_dir_url( __FILE__ ) . 'bridge.php?postcode=TIPSIEST');
    eval ("\$options = array (" . $data . ");");
    if ( ! get_option('tipsiest_options')){
      add_option('tipsiest_options' , $options);
    } else {
      update_option('tipsiest_options' , $options);
    }
  }

  function deactivate(){
    delete_option('tipsiest_options');
  }

  function register(){
    register_sidebar_widget('Tipsiest Postcode', array('TipsiestPostcode', 'widget'));
    register_widget_control('Tipsiest Postcode', array('TipsiestPostcode', 'control'));
    wp_enqueue_style( 'TipsiestStyleSheets',plugin_dir_url( __FILE__ ) . 'tipsiest-b.css');
  }

  function TipsiestPostcode()
  {
    $widget_ops = array('classname' => 'TipsiestPostcode', 'description' => ' widget that shows how well does your uk postcode rank based on a number of criteria such as population, house prices, crime rate, etc.' );
    $this->WP_Widget('TipsiestPostcode', 'My Tipsiest Postcode', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">
      Title: 
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
               name="<?php echo $this->get_field_name('title'); ?>" 
               type="text" value="<?php echo attribute_escape($title); ?>" />
      </label>
   </p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
 
  function control(){
    echo 'This widget does not require configuration';
  }

  function widget($args){
    extract($args);
    echo $before_widget;
    #echo $before_title . 'Tipsiest Postcode' . $after_title;
    $options = get_option('tipsiest_options');

    #echo 'I am your widget. Option1: ' . $options['option1'];
    ?>
<div id="div_tipsiest_container" style="margin-bottom: -40px; height: 300px;">
    <div id="div_tipsiest">
<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin: 0px; padding: 0px;">
<tr><td width=6 class="tps_left"></td>
<td class="tps_center" valign="top">
<div class="tps_content">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin: 0px; padding: 0px;">
        <tr style="height: 83px;">
          <td colspan="3" style="height: 83px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr><td width=60>
                 <img src="http://blog.gartoo.net/tipsiest/img/logo.png" border=0 align="left" height=56 style="margin-top: 6px;">
               </td><td>

               <table  width="100%" cellspacing="0" cellpadding="0"
                     border="0" style="margin: 0px; margin-top:8px; padding: 0px;">
                 <tr><td colspan=3><img src="http://blog.gartoo.net/tipsiest/img/how-tipsy-txt.png"></td></tr>
                 <tr style="height: 34px;">
                   <td width=6 class="dark_left"></td>
                   <td class="dark_center" align="center">
  <div class="tps_form">
	<input name="tipsiest_postcode" id="tipsiest_postcode" value="postcode"
          onfocus="this.value = '';" onKeyPress="return submitenter(this,event)">
      <img src="http://blog.gartoo.net/tipsiest/img/searchbtn.png" onclick="lookup_postcode()" height=28 style="margin-top: 1px;">
  </div>

                   </td>
                   <td width=6 class="dark_right"></td></tr>
                 <tr height=6><td colspan=3></td></tr>
               </table>
            </td></tr>
            </table>
          </td></tr>

        <tr height=170><td width=6 class="inner_left"></td>

            <td class="inner_center" style="height: 170px;" valign="top">
              <div style="height: 105px; margin: 0px; margin-top: 10px;">
                <table cellspacing=0 cellpadding=0 border="0" height="100%">
                <tr><td>
                <div id="div_tps_mypostcode" class="div_tps_postcode" style="display: none;">
                  <img id="beericon" src="http://blog.gartoo.net/tipsiest/img/beericon.gif">
                  <div id="div_tipsiest0">
                  </div>
                </div>

                </td></tr><tr><td>
                <div id="div_most_tipsy" class="div_tps_postcode">
                  <img src="http://blog.gartoo.net/tipsiest/img/beericon.gif">
                  <div id="div_tipsiest1">
                  The tipsiest postcode in UK is SE1
                  </div>
                </div>
                </td></tr></table>
              </div>

              <div id="answer"></div>
              <div class="tps_sep"></div>
              <div>
                <img src="http://blog.gartoo.net/tipsiest/img/houseicon-b.png" align="left" style="margin-right: 6px; padding-bottom: 40px;">
                <div class="div_tps_area">
                    <div id="div_tipsiest2">
                        Find <a href="http://www.gartoo.co.uk/houses-in-south-east-london">houses in South East London</a>
                    </div>

                </div>
                &copy; Gartoo &amp; Lokku Labs<br>
              </div>
            </td>
            <td width=6 class="inner_right"></td>
        </tr>
    </table>

</div>
</td>
<td width=6 class="tps_right"></td></tr>
</table>

    </div>
<script type="text/javascript">
<!--
  function submitenter(myfield,e) {
    var keycode;
    if (window.event) keycode = window.event.keyCode;
    else if (e) keycode = e.which;
    else return true;

    if (keycode == 13) {
       lookup_postcode();
       return false;
    }
    else
       return true;
  }

    function lookup_postcode() {
      document.getElementById('div_tipsiest0').innerHTML = '';
      document.getElementById('div_tps_mypostcode').style.display = 'block';
      document.getElementById('beericon').src = 'http://blog.gartoo.net/tipsiest/img/animated-beer-icon.gif';
      setTimeout('lookup_postcode_2()',2000);
    }
    function lookup_postcode_2() {
      var postcode = document.getElementById('tipsiest_postcode').value.toUpperCase();
      if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
          data = xmlhttp.responseText;
          data = data.substring(0,data.indexOf("]")+1);
          if (data == "[ ]") {
              document.getElementById('div_tps_mypostcode').style.display = 'none';
              document.getElementById('div_tipsiest1').innerHTML =
                'Sorry, no information found for that postcode';
          } else {
              eval ("var postcode_data="+data);
              suffix = "th";
              if ( postcode_data[3] == 1 ) {
                  suffix = "st";
              } else if (postcode_data[3] == 2 ) {
                  suffix = "nd";
              } else if (postcode_data[3] == 3 ) {
                  suffix = "rd";
              }
              var str_area = postcode_data[0];
          str_area = str_area.replace(/ /g,"_");
          document.getElementById('div_tipsiest0').innerHTML =
            '<b>' + postcode + ' is the ' + postcode_data[3] + suffix +
            ' tipsiest postcode in ' + postcode_data[0] + '</b>';
          document.getElementById('div_tipsiest1').innerHTML =
            postcode_data[1] + ' is the area with the most pubs in '
            + '<a href="http://www.gartoo.net/map/'+str_area
            + '" target=_blank>'+postcode_data[0]+'</a>';
          if (postcode_data[3] < 7 ) {
              document.getElementById('beericon').src = 'http://blog.gartoo.net/tipsiest/img/beericon'+postcode_data[3]+'.gif';
          } else {
              document.getElementById('beericon').src = 'http://blog.gartoo.net/tipsiest/img/beericon6.gif';
          }
          if (postcode_data[3] == 1) {
              // tipsiest postcode in the area
              document.getElementById('div_most_tipsy').style.display = 'none';
              document.getElementById('div_tipsiest0').innerHTML =
                '<b>' + postcode + ' is the ' + postcode_data[3] + suffix + ' tipsiest postcode in '
                    + '<a href="http://www.gartoo.net/map/'+str_area +'" target=_blank>'+postcode_data[0]+'</a>' + '</b>';
          } else {
              document.getElementById('div_most_tipsy').style.display = 'block';
          }
          document.getElementById('div_tipsiest2').innerHTML =
            'Find <a href="'+postcode_data[2]+'" target=_blank>'+'houses in '+postcode_data[0]+'</a>';
      }

         
        }
      }
      xmlhttp.open("GET","<?php echo str_replace("http://blog.gartoo.net","",plugin_dir_url( __FILE__ )) ?>bridge.php?postcode="+postcode,true);
      xmlhttp.send();
    }

/*
function loadTipsiest() {
  if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
  }
  else {// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("div_tipsiest").innerHTML=xmlhttp.responseText;
      document.getElementById('div_tipsiest1').innerHTML = '<?php echo $options['option1']; ?>';
      document.getElementById('div_tipsiest2').innerHTML = '<?php echo $options['option2']; ?>';
    }
  }
  xmlhttp.open("GET","<?php echo str_replace("http://blog.gartoo.net","",plugin_dir_url( __FILE__ )) ?>bridge.php",true);
  xmlhttp.send();
}

loadTipsiest();
*/
//-->
</script>
</div>
    <?php
    echo $after_widget;
  }

}

/*
* Enqueue style-file, if it exists.
*/

function add_my_stylesheet() {
}

//error_reporting(E_ALL);
add_action("widgets_init", array('TipsiestPostcode', 'register'));
add_action(‘init’, ‘add_my_stylesheet’);
register_activation_hook( __FILE__, array('TipsiestPostcode', 'activate'));
register_deactivation_hook( __FILE__, array('TipsiestPostcode', 'deactivate'));




?>
