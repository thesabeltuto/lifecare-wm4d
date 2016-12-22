<?php
function lifecare_wm4d_support() {
	?>
    <div class="lifecare_wm4d_wrap">
    <h1>LifeCare WM4D Theme and WM4D Options Integration Support</h1>
    <div id="wm4d_nav">
        <ul>
            <li id="lifecare_wm4d_li0" class="active"><a href="?page=lifecare_wm4d_support">Home</a></li>
            <li id="lifecare_wm4d_li1"><a href="?page=parent">soulmedic Geo</a></li>
            <li id="lifecare_wm4d_li2"><a href="?page=wm4d_options">WM4D Options</a></li>
            <li id="lifecare_wm4d_li2"><a href="nav-menus.php">Menu</a></li>
            <li id="lifecare_wm4d_li2"><a href="?page=layerslider">Slider</a></li>
       </ul>
    </div>
    
    <div class="content" id="theme_support">
    <h2>WM4D Shortcodes Inside Soulmedic Shortcodes Support</h2>
    <hr />
    <p>Inception, I know...</p>

    <h3>LifeCare and WM4D Integration Shortcodes</h3>
    <hr />
    <p>Allowed WM4D Shortcodes only work within <strong>( title="", phone="", location="", url="" )</strong> tags.<br />
    	Otherwise, use the original shortcode stated in the WM4D Options Plugin.<br />
        <a href="?page=wm4d_options">Click here</a> to get ID numbers of each item.</p>

    <div class="lifecare_wm4d_section support">
    <table border="0" cellspacing="0" cellpadding="8" class="lifecare_wm4d_table_support">
        <thead>
            <th>Name</th>
            <th>Code</th>
            <th>Allowed In</th>
        </thead>
        <tr>
            <td><strong>Client Name</strong></td>
            <td><strong>%client_name%</strong></td>
            <td><strong>Menu</strong><br />
            	<strong>Title Box</strong><br />
                <strong>Title Box Colored</strong><br />
                <strong>Info Box</strong><br />
            </td>
        </tr>
        <tr>
            <td><strong>Practice Name</strong></td>
            <td><strong>%practice_name%</strong></td>
            <td><strong>Menu</strong><br />
            	<strong>Title Box</strong><br />
                <strong>Title Box Colored</strong><br />
                <strong>Info Box</strong><br />
            </td>
        </tr>
        <?php if ( get_option('wm4d_multiple_select') != 'enable') { ?>
        <tr>
            <td><strong>Doctor Name</strong></td>
            <td><strong>%doctor_name%</strong></td>
            <td><strong>Menu</strong><br />
            	<strong>Title Box</strong><br />
                <strong>Title Box Colored</strong><br />
                <strong>Info Box</strong><br />
            </td>
        </tr>
        <tr>
            <td><strong>Doctor Name with Titles</strong></td>
            <td><strong>%doctor_title%</strong></td>
            <td><strong>Menu</strong><br />
            	<strong>Title Box</strong><br />
                <strong>Title Box Colored</strong><br />
                <strong>Info Box</strong><br />
            </td>
        </tr>
        <tr>
            <td><strong>Phone Number</strong></td>
            <td><strong>%phone_number%</strong></td>
            <td><strong>Title Box</strong><br />
                <strong>Title Box Colored</strong><br />
                <strong>Info Box</strong><br />
                <strong>Appointment: Phone</strong><br />
           </td>
        </tr>
        <tr>
            <td><strong>Location</strong></td>
            <td><strong>%location%</strong></td>
            <td><strong>Title Box</strong><br />
                <strong>Title Box Colored</strong><br />
                <strong>Info Box</strong><br />
                <strong>Appointment: Address Lines</strong><br />
            </td>
        </tr>
        <?php } ?>
        <?php if ( get_option('wm4d_multiple_select') == 'enable') { ?>
        <tr>
            <td><strong>Doctor Names</strong></td>
            <td><strong>%doctor_names%</strong><br />
            	-- show all doctors' names<br />
            	<strong>%doctor_names_#%</strong><br />
                -- <strong>#</strong> - ID number of the doctor
            </td>
            <td><strong>Menu</strong><br />
            	<strong>Title Box</strong><br />
                <strong>Title Box Colored</strong><br />
                <strong>Info Box</strong><br />
            </td>
        </tr>
        <tr>
            <td><strong>Doctor Names with Titles</strong></td>
            <td><strong>%doctor_titles%</strong><br />
            	-- show all doctors' names with titles<br />
            	<strong>%doctor_titles_#%</strong><br />
                -- <strong>#</strong> - ID number of the doctor
            </td>
            <td><strong>Menu</strong><br />
            	<strong>Title Box</strong><br />
                <strong>Title Box Colored</strong><br />
                <strong>Info Box</strong><br />
            </td>
        </tr>
        <tr>
            <td><strong>Phone Numbers</strong></td>
            <td><strong>%phone_numbers%</strong><br />
            	-- show all phone numbers<br />
            	<strong>%phone_numbers_#%</strong><br />
                -- <strong>#</strong> - ID number of the phone number<br/>
                <strong>%phone_numbers_menu%</strong><br/>
                -- show all phone numbers in menu (formatted)
            </td>
            <td><strong>Menu</strong><br />
            	<strong>Title Box</strong><br />
                <strong>Title Box Colored</strong><br />
                <strong>Info Box</strong><br />
                <strong>Appointment: Phone</strong><br />
           </td>
        </tr>
        <tr>
            <td><strong>Locations</strong></td>
            <td><strong>%locations%</strong><br />
            	-- show all locations<br />
            	<strong>%locations_#%</strong><br />
                -- <strong>#</strong> - ID number of the office location
            </td>
            <td><strong>Title Box</strong><br />
                <strong>Title Box Colored</strong><br />
                <strong>Info Box</strong><br />
                -- <strong>Appointment: Address Lines</strong><br />
            </td>
        </tr>
        <tr>
        	<td><strong>Multi Data</strong></td>
            <td><strong>%multi_data%</strong><br />
            	-- formatted according to needs
            </td>
            <td><strong>Responsive Styled Google Maps</strong><br />
            	-- Addresses (formatted)<br />
                -- Descriptions (formatted)<br />
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td><strong>Site URL</strong></td>
            <td><strong>%self%</strong></td>
            <td><strong>Appointment: Web URL</strong><br />
            </td>
        </tr>
    </table>
    </div>
    
    <h3>Soulmedic Page: Boxes Shortcodes</h3>
    <hr />
    <p>Allowed WM4D Shortcodes only work within the <strong>( title="" )</strong> tag.<br />
    	Otherwise, use the original shortcode stated in the WM4D Options Plugin.<br />
		<a href="?page=wm4d_options">Click here</a> to get ID numbers of each item.</p>
   <div class="lifecare_wm4d_section support">
    <table border="0" cellspacing="0" cellpadding="8" class="lifecare_wm4d_table_support">
        <thead>
            <th>Style</th>
            <th>Starting Code</th>
            <th>Ending Code</th>
            <th>Allowed WM4D Shortcode</th>
        </thead>
        <tr>
            <td><strong>Title Box</strong> - (Common Box Used)</td>
            <td><strong>[dt_sc_titled_box  icon="fa-info-circle" type="titled-box" title="" variation="color1"]</strong></td>
            <td><strong>[/dt_sc_titled_box]</strong></td>
            <td><strong>%client_name%</strong><br />
            	<strong>%practice_name%</strong><br />
				<?php if ( get_option('wm4d_multiple_select') != 'enable') { ?>
                    <strong>%doctor_name%</strong><br />
                    <strong>%doctor_title%</strong><br />
                    <strong>%phone_number%</strong><br />
                    <strong>%location%</strong><br />
                <?php } ?>
 				<?php if ( get_option('wm4d_multiple_select') == 'enable') { ?>
                    <strong>%doctor_names%</strong><br />
                    <strong>%doctor_names_#%</strong><br />
                    <strong>%doctor_titles%</strong><br />
                    <strong>%doctor_titles_#%</strong><br />
                    <strong>%phone_numbers%</strong><br />
                    <strong>%phone_numbers_#%</strong><br />
                    <strong>%locations%</strong><br />
                    <strong>%locations_#%</strong><br />
                <?php } ?>
          </td>
        </tr>
        <tr>
            <td><strong>Title Box Colored</strong> - (Why Choose Us)</td>
            <td><strong>[dt_sc_icon_box_colored fontawesome_icon='' title='' bgcolor='#4abcd7' ]</strong></td>
            <td><strong>[/dt_sc_icon_box_colored]</strong></td>
            <td><strong>%client_name%</strong><br />
            	<strong>%practice_name%</strong><br />
				<?php if ( get_option('wm4d_multiple_select') != 'enable') { ?>
                    <strong>%doctor_name%</strong><br />
                    <strong>%doctor_title%</strong><br />
                    <strong>%phone_number%</strong><br />
                    <strong>%location%</strong><br />
                <?php } ?>
 				<?php if ( get_option('wm4d_multiple_select') == 'enable') { ?>
                    <strong>%doctor_names%</strong><br />
                    <strong>%doctor_names_#%</strong><br />
                    <strong>%doctor_titles%</strong><br />
                    <strong>%doctor_titles_#%</strong><br />
                    <strong>%phone_numbers%</strong><br />
                    <strong>%phone_numbers_#%</strong><br />
                    <strong>%locations%</strong><br />
                    <strong>%locations_#%</strong><br />
                <?php } ?>
           </td>
        </tr>
        <tr>
            <td><strong>Info Box</strong> - (Other info pair with H4)</td>
            <td><strong>[dt_sc_titled_box type="info-box" title=""]</strong></td>
            <td><strong>[/dt_sc_titled_box]</strong></td>
            <td><strong>%client_name%</strong><br />
            	<strong>%practice_name%</strong><br />
				<?php if ( get_option('wm4d_multiple_select') != 'enable') { ?>
                    <strong>%doctor_name%</strong><br />
                    <strong>%doctor_title%</strong><br />
                    <strong>%phone_number%</strong><br />
                    <strong>%location%</strong><br />
                <?php } ?>
 				<?php if ( get_option('wm4d_multiple_select') == 'enable') { ?>
                    <strong>%doctor_names%</strong><br />
                    <strong>%doctor_names_#%</strong><br />
                    <strong>%doctor_titles%</strong><br />
                    <strong>%doctor_titles_#%</strong><br />
                    <strong>%phone_numbers%</strong><br />
                    <strong>%phone_numbers_#%</strong><br />
                    <strong>%locations%</strong><br />
                    <strong>%locations_#%</strong><br />
                <?php } ?>
           </td>
        </tr>
    </table>
    </div>
    

    <h3>Soulmedic Page: Appointment Shortcodes</h3>
    <hr />
    <p> Appointment Shortcodes commonly used in Contact Us page.<br />
    	Allowed WM4D Shortcodes only work within <strong>( title="", phone="", location="", url="" )</strong> tags.<br />
    	Otherwise, use the original shortcode stated in the WM4D Options Plugin.<br />
		<a href="?page=wm4d_options">Click here</a> to get ID numbers of each item.</p>
    <div class="lifecare_wm4d_section support">
    <table border="0" cellspacing="0" cellpadding="8" class="lifecare_wm4d_table_support">
        <thead>
            <th>Style</th>
            <th>Starting Code</th>
            <th>Ending Code</th>
            <th>Allowed WM4D Shortcode</th>
        </thead>
        <tr>
            <td><strong>Appointment Container</strong> - (Container Box Used)</td>
            <td><strong>[dt_sc_book_appointment]</strong></td>
            <td><strong>[/dt_sc_book_appointment]</strong></td>
            <td>-none-</td>
        </tr>
        <tr>
            <td><strong>Address</strong> - (Address Location)</td>
            <td><strong>[dt_sc_address line1="" line2="" line3="" line4="" /]</strong></td>
            <td>-none-</td>
            <td><?php if ( get_option('wm4d_multiple_select') != 'enable') { ?>
                    <strong>%location%</strong>
                <?php } ?>
 				<?php if ( get_option('wm4d_multiple_select') == 'enable') { ?>
                    <strong>%locations%</strong><br />
                    <strong>%locations_#%</strong><br />
                    (input shortcode in lines needed)
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td><strong>Phone Number</strong></td>
            <td><strong>[dt_sc_phone phone="" /]</strong></td>
            <td>-none-</td>
            <td><?php if ( get_option('wm4d_multiple_select') != 'enable') { ?>
                    <strong>%phone_number%</strong>
                <?php } ?>
 				<?php if ( get_option('wm4d_multiple_select') == 'enable') { ?>
                    <strong>%phone_numbers%</strong><br />
                    <strong>%phone_numbers_#%</strong><br />
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td><strong>Web URL</strong></td>
            <td><strong>[dt_sc_web url="" /]</strong></td>
            <td>-none-</td>
            <td><strong>%self%</strong></td>
        </tr>
	</table>
    </div>

    <h3>Soulmedic Page: Lists Shortcodes</h3>
    <hr />
    <div class="lifecare_wm4d_section support">
    <table border="0" cellspacing="0" cellpadding="8" class="lifecare_wm4d_table_support">
        <thead>
            <th>Style</th>
            <th>Starting Code</th>
            <th>Ending Code</th>
        </thead>
        <tr>
            <td><strong>OL</strong> - (numbered)</td>
            <td><strong>[dt_sc_fancy_ol style="" variation="color1"]</strong></td>
            <td><strong>[/dt_sc_fancy_ol]</strong></td>
        </tr>
        <tr>
            <td><strong>UL</strong> - (not numbered)</td>
            <td><strong>[dt_sc_fancy_ul style="" variation="color1"]</strong></td>
            <td><strong>[/dt_sc_fancy_ul]</strong></td>
        </tr>
        <tr>
            <td><strong>Manual List</strong> - (BOX NUMBER)</td>
            <td><strong>[dt_sc_manual_list type="type1"]</strong></td>
            <td><strong>[/dt_sc_manual_list]</strong></td>
        </tr>
        <tr>
            <td><strong>Box Number</strong></td>
            <td><strong>[dt_sc_box]</strong></td>
            <td><strong>[/dt_sc_box]</strong></td>
        </tr>
    </table>
    </div>

    <h3>Soulmedic Page: Space and Divisions Shortcodes</h3>
    <hr />
    <div class="lifecare_wm4d_section support">
    <table border="0" cellspacing="0" cellpadding="8" class="lifecare_wm4d_table_support">
        <thead>
            <th>Style</th>
            <th>Starting Code</th>
            <th>Ending Code</th>
        </thead>
        <tr>
            <td><strong>Clear Both</strong> - (space for clearing divisions)</td>
            <td><strong>[dt_sc_clear]</strong></td>
            <td>-none-</td>
        </tr>
        <tr>
            <td><strong>HR</strong> - (invisible line)</td>
            <td><strong>[dt_sc_hr_invisible]</strong></td>
            <td>-none-</td>
        </tr>
        <tr>
            <td><strong>1/2</strong>- (division 1/2)</td>
            <td><strong>[dt_sc_one_half]</strong></td>
            <td><strong>[/dt_sc_one_half]</strong></td>
        </tr>
        <tr>
            <td><strong>1/3</strong> - (division 1/3)</td>
            <td><strong>[dt_sc_one_third]</strong></td>
            <td><strong>[/dt_sc_one_third]</strong></td>
        </tr>
        <tr>
            <td><strong>2/3</strong>- (division 2/3)</td>
            <td><strong>[dt_sc_box]</strong></td>
            <td><strong>[/dt_sc_box]</strong></td>
        </tr>
    </table>
    </div>

    <h3>Layer Slider Settings</h3>
    <hr />
    <div class="lifecare_wm4d_section support">
    <table border="0" cellspacing="0" cellpadding="8" class="lifecare_wm4d_table_support">
        <thead>
            <th>Slide / Section</th>
            <th>ID Attribute</th>
            <th>Class Attribute</th>
            <th>Link</th>
        </thead>
        <tr>
            <td><strong>Slide Options</strong> - (Slider General Settings)</td>
            <td><strong>offer-banner</strong></td>
            <td>-none-</td>
            <td>-none-</td>
        </tr>
        <tr>
            <td><strong>People Image</strong> - (Slider Image)</td>
            <td><strong>offer-banner-bg</strong></td>
            <td>-none-</td>
            <td>-none-</td>
        </tr>
        <tr>
            <td><strong>Offer Title</strong> - (Procedure Offer)</td>
            <td><strong>offer-banner-title</strong></td>
            <td>-none-</td>
            <td>-none-</td>
        </tr>
        <tr>
            <td><strong>Price Offer</strong> - (Procedure Price)</td>
            <td><strong>offer-banner-price</strong></td>
            <td>-none-</td>
            <td>-none-</td>
        </tr>
        <tr>
            <td><strong>Offer Description</strong> - (Procedure Details)</td>
            <td><strong>offer-banner-desc</strong></td>
            <td>-none-</td>
            <td>-none-</td>
        </tr>
        <tr>
            <td><strong>Sub Offers</strong> - (Procedure Sub-Offer)</td>
            <td><strong>offer-banner-free</strong></td>
            <td>-none-</td>
            <td>-none-</td>
        </tr>
        <tr>
            <td><strong>Offer Expires</strong> - (Offer Expiry)</td>
            <td><strong>offer-banner-offer</strong></td>
            <td><strong>datetoday</strong></td>
            <td>-none-</td>
        </tr>
        <tr>
            <td><strong>Request Button</strong> - (Click for Consult)</td>
            <td><strong>offer-banner-req</strong></td>
            <td><strong>various</strong></td>
            <td><strong>#gform-consult-form-4</strong></td>
        </tr>
        <tr>
            <td><strong>Extend Button</strong> - (Extend Offer)</td>
            <td><strong>offer-banner-ext</strong></td>
            <td><strong>various</strong></td>
            <td><strong>#gform-consult-form-3</strong></td>
        </tr>
        <tr>
            <td><strong>Additional Info</strong> - (Why Choose Us Image)</td>
            <td><strong>offer-banner-img</strong></td>
            <td>-none-</td>
            <td>-none-</td>
        </tr>
        <tr>
            <td><strong>Additional Description</strong> - (2nd Description)</td>
            <td><strong>offer-banner-desc2</strong></td>
            <td>-none-</td>
            <td>-none-</td>
        </tr>
    </table>
    </div>
    
    <h3>Responsive Styled Google Maps Settings</h3>
    <hr />
    <p>Allowed WM4D Shortcodes only work within <strong>( address="" and description="" )</strong> tags.<br />
		<a href="?page=wm4d_options">Click here</a> to get ID numbers of each item.</p>
    <div class="lifecare_wm4d_section support">
    <table border="0" cellspacing="0" cellpadding="8" class="lifecare_wm4d_table_support">
        <thead>
            <th>Input / Section</th>
            <th>Allowed WM4D Shortcodes</th>
        </thead>
        <tr>
            <td><strong>Address</strong> - (Map Address)</td>
            <td><strong>%practice_name%</strong><br />
				<?php if ( get_option('wm4d_multiple_select') != 'enable') { ?>
                    <strong>%location%</strong><br />
                <?php } ?>
 				<?php if ( get_option('wm4d_multiple_select') == 'enable') { ?>
                    <strong>%locations%</strong><br />
                    <strong>%locations_#%</strong><br />
                    <strong>%multi_data%</strong> (formatted)<br />
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td><strong>Description</strong> - (Map Details)</td>
            <td><strong>%client_name%</strong><br />
            	<strong>%practice_name%</strong><br />
				<?php if ( get_option('wm4d_multiple_select') != 'enable') { ?>
                    <strong>%doctor_name%</strong><br />
                    <strong>%doctor_title%</strong><br />
                    <strong>%phone_number%</strong><br />
                    <strong>%location%</strong><br />
                <?php } ?>
 				<?php if ( get_option('wm4d_multiple_select') == 'enable') { ?>
                    <strong>%doctor_names%</strong><br />
                    <strong>%doctor_names_#%</strong><br />
                    <strong>%doctor_titles%</strong><br />
                    <strong>%doctor_titles_#%</strong><br />
                    <strong>%phone_numbers%</strong><br />
                    <strong>%phone_numbers_#%</strong><br />
                    <strong>%locations%</strong><br />
                    <strong>%locations_#%</strong><br />
                    <strong>%multi_data%</strong> (formatted)<br />
                <?php } ?>
            </td>
        </tr>
	</table>
    </div>
    
    <h3>&nbsp;</h3>
    <h3>LifeCare WM4D Theme Support</h3>
    <hr />
    <p>Version <?=$GLOBALS['THEME_VERSION']?>. Created by <a href="http://thesabeltuto.blogspot.com/" target="_blank">Thesabel Tuto</a> and Geophy Lawrence Pagaspas.</p>
    <p>Child theme for the soulmedic theme. Integrated with WM4D-Options. Additional Testimonial Categories pages: Text Testimonials and Video Testimonials. Additional LifeCare-WM4D Shortcodes and Support Page.</p>


    </div>
    
    </div>
    <?php
}
?>