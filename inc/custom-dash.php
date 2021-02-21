<?php
/** DASH THEME ///// **/
if( is_admin() ){
  add_action('admin_menu', 'theme_dash_menu_add');
}
function theme_dash_menu_add() {
  $theme_menu_title = 'Tema Ayarları';
	add_menu_page('Tema Ayarları', $theme_menu_title, "install_themes", "theme-dash", 'theme_setting_page_render' , 'dashicons-hammer', 60 );
  add_action( 'admin_init', 'register_theme_settings' );
}

function register_theme_settings() {
  register_setting( 'theme_settings_group_data', 'setting_specialtopics' );
  register_setting( 'theme_settings_group_data', 'setting_site_colors' );

  register_setting( 'theme_settings_group_data', 'setting_home_navigation' );
  register_setting( 'theme_settings_group_data', 'setting_home_navigation_border' );
  register_setting( 'theme_settings_group_data', 'setting_home_navigation_count' );

  register_setting( 'theme_settings_group_data', 'setting_extracode' );
  register_setting( 'theme_settings_group_data', 'setting_all_socialmedia' );
  register_setting( 'theme_settings_group_data', 'setting_app_store_links' );
  register_setting( 'theme_settings_group_data', 'setting_footer_desc' );
  register_setting( 'theme_settings_group_data', 'setting_slider_bottom' );
  register_setting( 'theme_settings_group_data', 'setting_header_desc' );
  register_setting( 'theme_settings_group_data', 'setting_siteici_kod_alanlari' );

  register_setting( 'theme_settings_group_data', 'setting_yapim_asamasinda' );
  register_setting( 'theme_settings_group_data', 'setting_yapim_asamasinda_url' );

  register_setting( 'theme_settings_group_data', 'setting_gallery_cat_video' );
  register_setting( 'theme_settings_group_data', 'setting_gallery_cat_photo' );
  register_setting( 'theme_settings_group_data', 'setting_sondakika_cat_id' );
}

// sortable jquery
function load_wp_media_core_jsfiles() {
  wp_enqueue_script('jquery-ui-sortable');
  wp_enqueue_style( 'wp-color-picker' );
  wp_enqueue_script( 'wp-color-picker');
}
if( is_admin() ){
  add_action( "admin_enqueue_scripts", "load_wp_media_core_jsfiles" );
}

function theme_setting_page_render() { ?>
  <style>
    .theme-dash-savebtn { position: fixed; right: 20px; bottom: 20px; padding: 20px; }
    .theme-dash-savebtn input { font-size:17px !important; }
    .color-field { padding-right: 100px; position:relative; white-space: nowrap; }
    .wp-picker-container { position:absolute; margin-left: 5px; margin-top: -7px; }
    .wp-picker-container.wp-picker-active { position:absolute; z-index:1; background:#fff; }
    details { border: 1px solid #5f5f5f; border-radius: 0.25rem; margin:15px 15px 15px 0; box-shadow: 0px 0px 3px #0000003b; }
    details summary { font-size: 1rem; color: #000; cursor: pointer; padding: 15px; }
    details summary:focus { outline:0 }
    details section { display:flex; align-items: center; flex-wrap: wrap; padding: 15px; border-top: 1px dashed #dddddd; }
    details section h3 { margin-bottom: 10px; flex: 100%; }
    details section small { color:gray; }
    details section input, details section select, details section textarea{ display:block; }
    input[type=color] { display:inline-block; }
    .ui-state-highlight { background:#dedede; }
    .clear-flex{ flex:100%; }
    .wrap-items { border-bottom: 1px dashed #dddddd; }
    .btn-new-item { margin:20px !important; }
  </style>
  <div class="wrap-dash">
    <h1 style="margin-bottom:30px;">Tema Ayarları</h1>

    <form class="theme-dash" method="post" action="options.php">
      <?php 
      settings_fields( 'theme_settings_group_data' );
      do_settings_sections( 'theme_settings_group_data' );
      ?>

      HHGSUN: custom-dash.php sayfasını geliştir. her tip de alan yapısı olsun ve hepsi stabil şekilde olsun çünkü bu tema standart olacak.
      <br>
      - input tipler: text, textarea, color, dropdown-menu, checkbox
      <br>
      - css yapısını güzelleştir, javascript yapısını geliştir.
      <br>
      - panel e özellik ekleme kısımlarını daha dinamik hale getir.
      <br>

      <details id="panel_setting_specialtopics">
        <summary>Anasayfa Konu Başlıkları</summary>
        <div class="wrap-items" style="border-bottom:2px dashed #898888;">
          <?php if(get_option('setting_specialtopics')) {
            foreach (get_option('setting_specialtopics') as $key => $value) {
              $baslik = isset($value['baslik']) ? $value['baslik'] : '';
              $baslikLink = isset($value['baslik-link']) ? $value['baslik-link'] : '';
              $ozelKod = isset($value['ozel-kod']) ? $value['ozel-kod'] : '';
              $sablon = isset($value['sablon']) ? $value['sablon'] : '';
              $bgColor = isset($value['bg-color']) ? $value['bg-color'] : '';
              $textColor = isset($value['text-color']) ? $value['text-color'] : '';
              $borderColor = isset($value['border-color']) ? $value['border-color'] : '';
            ?>
            <section class="ui-sortable-handle" style="justify-content: space-between; padding:5px 15px 30px 15px; flex-direction: column; border-top:2px dashed #898888;">
              <button type="button" class="btn-delete-item" style="margin-left:auto; margin-right: 10px;"><span class="dashicons dashicons-trash"></span></button>
              <div style="width: 100%; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">
                <span class="move-btn dashicons dashicons-sort"></span>
                <p>
                  Başlık
                  <input type="text" name="setting_specialtopics[<?php echo $key; ?>][baslik]" value="<?php echo $baslik; ?>" placeholder="Başlık" />
                  <input type="text" name="setting_specialtopics[<?php echo $key; ?>][baslik-link]" value="<?php echo $baslikLink; ?>" placeholder="Başlık Link" />
                </p>
                <div>
                  Haber Kaynağı
                </div>
                <p>
                  Özel kod <small>(şablon 5 için)</small>
                  <textarea name="setting_specialtopics[<?php echo $key; ?>][ozel-kod]" placeholder="Şablon 5 te gösterilmek üzere reklam vs. kodunuz" style="min-width:250px;height:auto;"><?php echo $ozelKod; ?></textarea>
                </p>
                <p>
                  Şablon
                  <select name="setting_specialtopics[<?php echo $key; ?>][sablon]">
                    <option value="sablon1" <?php echo $sablon == 'sablon1' ? 'selected' : ''; ?>>Şablon 1 (2 satır)</option>
                    <option value="sablon2" <?php echo $sablon == 'sablon2' ? 'selected' : ''; ?>>Şablon 2 (1 satır)</option>
                    <option value="sablon3" <?php echo $sablon == 'sablon3' ? 'selected' : ''; ?>>Şablon 3 (Tam Haber)</option>
                    <option value="sablon4" <?php echo $sablon == 'sablon4' ? 'selected' : ''; ?>>Şablon 4 (3 Banner)</option>
                    <option value="sablon5" <?php echo $sablon == 'sablon5' ? 'selected' : ''; ?>>Şablon 5 (Geniş Kod Alanı)</option>
                  </select>
                </p>
              </div>
              <div style="width: 100%; display: flex; align-items: center; justify-content: space-around; flex-wrap: wrap; margin: 10px;">
                <div style="display:flex;">
                  <div class="color-field">
                    Arkaplan Rengi:
                    <input type="text" name="setting_specialtopics[<?php echo $key; ?>][bg-color]" value="<?php echo $bgColor; ?>" data-default-color="" />
                  </div>
                  <div class="color-field">
                    Yazı Rengi:
                    <input type="text" name="setting_specialtopics[<?php echo $key; ?>][text-color]" value="<?php echo $textColor; ?>" data-default-color="" />
                  </div>
                  <div class="color-field">
                    Çerçeve Rengi:
                    <input type="text" name="setting_specialtopics[<?php echo $key; ?>][border-color]" value="<?php echo $borderColor; ?>" data-default-color="" />
                  </div>
                </div>
              </div>
            </section>
          <?php } } ?>
        </div>
        <button type="button" class="button btn-new-item">Yeni Ekle</button>
      </details><!-- .Anasayfa Konu Başlıkları -->

      <details>
        <summary>Site Renkleri</summary>
        <section>
          <div class="color-field">
            Üst Alan Arkaplan Rengi
            <input type="text" name="setting_site_colors[topbar-bg]" value="<?php echo esc_attr( get_option('setting_site_colors')['topbar-bg'] ); ?>" data-default-color="#0E2759" />
          </div>
          <div class="color-field">
            Üst Alan Yazı Rengi
            <input type="text" name="setting_site_colors[topbar-color]" value="<?php echo esc_attr( get_option('setting_site_colors')['topbar-color'] ); ?>" data-default-color="#4D93E8" />
          </div>
        </section>
        <section>
          <div class="color-field">
            Menü Arkaplan Rengi
            <input type="text" name="setting_site_colors[header-nav-bg]" value="<?php echo esc_attr( get_option('setting_site_colors')['header-nav-bg'] ); ?>" data-default-color="#00447C" />
          </div>
          <div class="color-field">
            Menü Yazı Rengi
            <input type="text" name="setting_site_colors[header-nav-color]" value="<?php echo esc_attr( get_option('setting_site_colors')['header-nav-color'] ); ?>" data-default-color="#ffffff" />
          </div>
        </section>
        <section>
          <div class="color-field">
            Üst Çerceve Rengi
            <input type="text" name="setting_site_colors[header-border-color]" value="<?php echo esc_attr( get_option('setting_site_colors')['header-border-color'] ); ?>" data-default-color="#5383ac" />
          </div>
        </section>
        <section>
          <div class="color-field">
            Manşet Arkaplan Rengi
            <input type="text" name="setting_site_colors[headlines-bg]" value="<?php echo esc_attr( get_option('setting_site_colors')['headlines-bg'] ); ?>" data-default-color="#085da3" />
          </div>
          <div class="color-field">
            Manşet Yazı Rengi
            <input type="text" name="setting_site_colors[headlines-color]" value="<?php echo esc_attr( get_option('setting_site_colors')['headlines-color'] ); ?>" data-default-color="#ffffff" />
          </div>
        </section>
        <section>
          <div class="color-field">
            Alt Arkaplan Rengi
            <input type="text" name="setting_site_colors[footer-bg]" value="<?php echo esc_attr( get_option('setting_site_colors')['footer-bg'] ); ?>" data-default-color="#00447C" />
          </div>
          <div class="color-field">
            Alt Yazı Rengi
            <input type="text" name="setting_site_colors[footer-color]" value="<?php echo esc_attr( get_option('setting_site_colors')['footer-color'] ); ?>" data-default-color="#ffffff" />
          </div>
        </section>
        <section>
          <div class="color-field">
            Odaklanma Rengi
            <input type="text" name="setting_site_colors[focus-color]" value="<?php echo esc_attr( get_option('setting_site_colors')['focus-color'] ); ?>" data-default-color="#f15a24" />
          </div>
        </section>
      </details><!-- .site renkleri -->

      <details id="panel_home_navigation">
        <summary>Anasayfa Navigasyon Linkleri</summary>
        <div class="wrap-items">
          <?php if(get_option('setting_home_navigation')) {
            foreach (get_option('setting_home_navigation') as $key => $value) {
              $title = isset($value['title']) ? $value['title'] : '';
              $icon = isset($value['icon']) ? $value['icon'] : '';
              $link = isset($value['link']) ? $value['link'] : '';
              $bgColor = isset($value['bg-color']) ? $value['bg-color'] : '';
              $color = isset($value['color']) ? $value['color'] : '';
              $bgImage = isset($value['bg-image']) ? $value['bg-image'] : '';
              ?>
            <section class="ui-sortable-handle">
              <span class="move-btn dashicons dashicons-sort"></span>
              <input type="text" name="setting_home_navigation[<?php echo $key; ?>][title]" value="<?php echo esc_attr( $title ); ?>" placeholder="Yazı" />
              <input type="text" name="setting_home_navigation[<?php echo $key; ?>][icon]" value="<?php echo esc_attr( $icon ); ?>" placeholder="Resim veya Icon kodu" />
              <input type="text" name="setting_home_navigation[<?php echo $key; ?>][link]" value="<?php echo esc_attr( $link ); ?>" placeholder="Link" />
              <div class="color-field" style="margin-left:10px">
                Arkaplan Rengi
                <input type="text" name="setting_home_navigation[<?php echo $key; ?>][bg-color]" value="<?php echo esc_attr( $bgColor ); ?>" data-default-color="#000" />
              </div>
              <div class="color-field">
                Yazı Rengi
                <input type="text" name="setting_home_navigation[<?php echo $key; ?>][color]" value="<?php echo esc_attr( $color ); ?>" data-default-color="#fff" />
              </div>
              <input type="text" name="setting_home_navigation[<?php echo $key; ?>][bg-image]" value="<?php echo esc_attr( $bgImage ); ?>" placeholder="Arkplan Resim Url" />
              <span class="btn-delete-item"><span class="dashicons dashicons-trash"></span></span>
            </section>
          <?php } } ?>
        </div>
        <button type="button" class="button btn-new-item">Yeni Ekle</button>
        <div style="padding:20px;">
          <div class="color-field" style="min-height:40px;">
            Sütun Sayısı
            <select name="setting_home_navigation_count">
              <option value="12" <?php echo get_option('setting_home_navigation_count') == '12' ? 'selected' : ''; ?>>1</option>
              <option value="6" <?php echo get_option('setting_home_navigation_count') == '6' ? 'selected' : ''; ?>>2</option>
              <option value="4" <?php echo get_option('setting_home_navigation_count') == '4' ? 'selected' : ''; ?>>3</option>
              <option value="3" <?php echo get_option('setting_home_navigation_count') == '3' ? 'selected' : ''; ?>>4</option>
            </select>
            Çerçeve Rengi
            <input type="text" name="setting_home_navigation_border" value="<?php echo esc_attr( get_option('setting_home_navigation_border') ); ?>" data-default-color="#000" />
          </div>
          <small> icon seti: https://fontawesome.com/icons?m=free, </small><br>
          <small> icon <code>&lt;i class="fab fa-facebook-square"&gt;&lt;/i&gt;</code>, </small><br>
          <small> link <code>http://socialmedia.com/hesap</code></small>
        </div>
      </details><!-- #panel_home_navigation -->

      <details id="panel_social_media_links">
        <summary>Sosyal Medya Hesapları</summary>
        <div class="wrap-items">
          <?php if(get_option('setting_all_socialmedia')) {
            foreach (get_option('setting_all_socialmedia') as $key => $value) { ?>
            <section class="ui-sortable-handle">
              <span class="move-btn dashicons dashicons-sort"></span>
              <input type="text" name="setting_all_socialmedia[<?php echo $key; ?>][title]" value="<?php echo esc_attr( $value['title'] ); ?>" placeholder="Sosyal medya başlık" />
              <input type="text" name="setting_all_socialmedia[<?php echo $key; ?>][icon]" value="<?php echo esc_attr( $value['icon'] ); ?>" placeholder="İcon kodu" />
              <input type="text" name="setting_all_socialmedia[<?php echo $key; ?>][link]" value="<?php echo esc_attr( $value['link'] ); ?>" placeholder="Sosyal medya link" />
              <span class="btn-delete-item"><span class="dashicons dashicons-trash"></span></span>
            </section>
          <?php } } ?>
        </div>
        <button type="button" class="button btn-new-item">Yeni Ekle</button>
        <div style="padding:20px;">
          <small> icon seti: https://fontawesome.com/icons?m=free, </small><br>
          <small> icon <code>&lt;i class="fab fa-facebook-square"&gt;&lt;/i&gt;</code>, </small><br>
          <small> link <code>http://socialmedia.com/hesap</code></small>
        </div>
        <section style="flex-direction: column;align-items: flex-start;">
          Android Uygulama Linki
          <input type="text" name="setting_app_store_links[google]" value="<?php echo isset(get_option('setting_app_store_links')['google']) ? get_option('setting_app_store_links')['google'] : ''; ?>" placeholder="Google Play Linki" />
          Apple Uygulama Linki
          <input type="text" name="setting_app_store_links[ios]" value="<?php echo isset(get_option('setting_app_store_links')['ios']) ? get_option('setting_app_store_links')['ios'] : ''; ?>" placeholder="App Store Linki" />
        </section>
      </details><!-- #panel_social_media_links -->

      <details>
        <summary>Site İçi Kod Alanları</summary>
        <section>
          <h4 style="margin:0">Sitenin üst kısmında gözükecek yazı(html) girebilirsiniz</h4>
          <textarea rows="4" cols="50" name="setting_header_desc" style="width:80%;" placeholder="yazı veya html içerik"><?php echo esc_attr( get_option('setting_header_desc') ); ?></textarea>
        </section>
        <section>
          <h4 style="margin:0">Sitenin alt kısmında gözükecek yazı(html) girebilirsiniz</h4>
          <textarea rows="4" cols="50" name="setting_footer_desc" style="width:80%;" placeholder="yazı veya html içerik"><?php echo esc_attr( get_option('setting_footer_desc') ); ?></textarea>
        </section>
        <section>
          <h4 style="margin:0">Sitenin orta kısmında gözükecek yazı(html) girebilirsiniz (slider hemen altı)</h4>
          <textarea rows="4" cols="50" name="setting_slider_bottom" style="width:80%;" placeholder="yazı veya html içerik"><?php echo esc_attr( get_option('setting_slider_bottom') ); ?></textarea>
        </section>
        <h3 style="margin-left:15px">Reklam Alanları</h3>
        <section>
          Sol Reklam Alanı (masaüstünde solda)
          <textarea rows="4" cols="50" name="setting_siteici_kod_alanlari[sol]" style="width:80%;" placeholder="yazı veya html içerik"><?php echo get_option('setting_siteici_kod_alanlari') ? get_option('setting_siteici_kod_alanlari')['sol'] : ''; ?></textarea>
        </section>
        <section>
          Sağ Reklam Alanı (masaüstünde sağda)
          <textarea rows="4" cols="50" name="setting_siteici_kod_alanlari[sag]" style="width:80%;" placeholder="yazı veya html içerik"><?php echo get_option('setting_siteici_kod_alanlari') ? get_option('setting_siteici_kod_alanlari')['sag'] : ''; ?></textarea>
        </section>
        <section style="flex-direction: column;align-items: flex-start;">
          Kategori Slider Altı (masaüstü ve mobilde)
          <textarea rows="4" cols="50" name="setting_siteici_kod_alanlari[kat_slider_alt]" style="width:80%;" placeholder="yazı veya html içerik"><?php echo get_option('setting_siteici_kod_alanlari') ? get_option('setting_siteici_kod_alanlari')['kat_slider_alt'] : ''; ?></textarea>
        </section>
        <section style="flex-direction: column;align-items: flex-start;">
          Kategori Sayfa Altı (masaüstü ve mobilde)
          <textarea rows="4" cols="50" name="setting_siteici_kod_alanlari[kat_sayfa_alt]" style="width:80%;" placeholder="yazı veya html içerik"><?php echo get_option('setting_siteici_kod_alanlari') ? get_option('setting_siteici_kod_alanlari')['kat_sayfa_alt'] : ''; ?></textarea>
        </section>
        <section style="flex-direction: column;align-items: flex-start;">
          Haber İçerik Sağ Bar (masaüstü)
          <textarea rows="4" cols="50" name="setting_siteici_kod_alanlari[post_icerik_sagbar]" style="width:80%;" placeholder="yazı veya html içerik"><?php echo get_option('setting_siteici_kod_alanlari') ? get_option('setting_siteici_kod_alanlari')['post_icerik_sagbar'] : ''; ?></textarea>
        </section>
        <section style="flex-direction: column;align-items: flex-start;">
          Haber İçerik Altı (masaüstü ve mobilde)
          <textarea rows="4" cols="50" name="setting_siteici_kod_alanlari[post_icerik_alt]" style="width:80%;" placeholder="yazı veya html içerik"><?php echo get_option('setting_siteici_kod_alanlari') ? get_option('setting_siteici_kod_alanlari')['post_icerik_alt'] : ''; ?></textarea>
        </section>
        <div style="margin:20px;">
          <code>ilgili alanlara kod satırları eklenebilir; Google Reklam kodları veya özel banner resim kodları eklenebilir</code>
        </div>
      </details><!-- .Site İçi Kod Alanları -->

      <details>
        <summary>Ekstra Kod</summary>
        <section>
          Header içi Kod
          <textarea rows="4" cols="50" name="setting_extracode[head]" style="width:80%;" placeholder="header'a javascript veya css kodu"><?php echo esc_attr( get_option('setting_extracode')['head'] ); ?></textarea>
        </section>
        <section>
          Footer içi Kod
          <textarea rows="4" cols="50" name="setting_extracode[foot]" style="width:80%;" placeholder="footer'a javascript veya css kodu"><?php echo esc_attr( get_option('setting_extracode')['foot'] ); ?></textarea>
          <div style="margin:10px 0;">
            <code>ilgili alanlara kod satırları eklenebilir; css ve js özel değişiklikler yapılabilir veya Google Analytics gibi özel kod bloğu eklenebilir</code>
            <br>
            <code>&lt;style&gt;body{background:red;}&lt;/style&gt;</code><br>
            <code>&lt;script&gt;alert('Hoşgeldiniz...');&lt;/script&gt;</code>
          </div>
        </section>
      </details><!-- .ekstra kod  -->

      <details>
        <summary>Diğer Ayarlar</summary>
        <section>
          <label for="yapimda" style="margin-right:5px;">Site Yapım Aşamasında</label>
          <input type="checkbox" id="yapimda" name="setting_yapim_asamasinda" value="1" <?php echo get_option('setting_yapim_asamasinda') ? 'checked' : ''; ?> />
          <input type="text" id="yapimda_url" name="setting_yapim_asamasinda_url" value="<?php echo esc_attr( get_option('setting_yapim_asamasinda_url') ); ?>" placeholder="Yönlenecek Url" />
        </section>
        <section>
          Video Galeri İçin Bir Kategori:
          <?php wp_dropdown_categories( array(
            'show_option_none' => 'Video Galeri için kategori seçin',
            'hide_empty' => 0,
            'name' => 'setting_gallery_cat_video',
            'selected' => get_option('setting_gallery_cat_video')
          ) ); ?>
        </section>
        <section>
          Foto Galeri İçin Bir Kategori:
          <?php wp_dropdown_categories( array(
            'show_option_none' => 'Foto Galeri için kategori seçin',
            'hide_empty' => 0,
            'name' => 'setting_gallery_cat_photo',
            'selected' => get_option('setting_gallery_cat_photo')
          ) ); ?>
        </section>
        <section>
          Sondakika Logosu için bir kategori:
          <?php wp_dropdown_categories( array(
            'show_option_none' => 'Sondakika Logosu için kategori seçin',
            'hide_empty' => 0,
            'name' => 'setting_sondakika_cat_id',
            'selected' => get_option('setting_sondakika_cat_id')
          ) ); ?>
        </section>
      </details><!-- .diğer ayarlar  -->

      <div class="theme-dash-savebtn"><?php submit_button(); ?></div>
    </form>
  </div><!-- /.wrap-dash -->

  <script>
    jQuery(document).ready(function($){
      /** */      
      // SORTABLE ITEMS
      $( ".wrap-items" ).sortable({ placeholder: "ui-state-highlight" });
      $( ".wrap-items" ).disableSelection();
      /** */
      // COLOR PICKER
      $('.color-field input').each(function(){
        $(this).wpColorPicker({
          palettes: [
            '#fcc10f', //sarı
            '#ed1e1e', //kırmızı
            '#237aed', //mavi
            '#09ba15', //yeşil
            '#ff9205', //turuncu
            '#111111', //siyat
            '#ffffff', //beyaz
            '#ad1bfc', //mor
            '#2512b7', //lacivert
            '#8e3008', //kahverengi
            '#ea75c1', //pembe
            '#1dd6d6', //turkuaz
            '#5a6468', //gri
            '#0081cc', //acık mavi
          ]
        });
      });
      /** */

      // DELETE ITEM
      $(document).on('click', '.btn-delete-item', function(){
        var sor = confirm('Kaldırmak istediğinize eminmisiniz?');
        if(sor){
          var itemParent = $(this).parent()[0];
          itemParent.remove();
        }
      });

      /**
       * ADD ITEMs (sadece 2 yer değiştirilmesi yeterli: ana div id si ve itemName)
       */

      // SPECIAL TOPICS -custom-id
      $('#panel_setting_specialtopics').on('click', '.btn-new-item', function(e){
        var itemName = 'setting_specialtopics'; // Custom Name Value
        var itemKey = Date.now();
        var item = `<section class="ui-sortable-handle">
          <span class="move-btn dashicons dashicons-sort"></span>
          <input type="text" name="${itemName}['${itemKey}'][baslik]" value="" placeholder="Başlık" />
          <span class="btn-delete-item"><span class="dashicons dashicons-trash"></span></span> Diğer düzenlemeleri kaydettikten sonra yapabilirsiniz.'
        </section>`;
        $(e.target).prev('.wrap-items').append(item);
      });

      // SOCIAL MEDIA -custom-id
      $('#panel_social_media_links').on('click', '.btn-new-item', function(e){
        var itemName = 'setting_all_socialmedia'; // Custom Name Value
        var itemKey = Date.now();
        var item = `<section class="ui-sortable-handle">
            <span class="move-btn dashicons dashicons-sort"></span>
            <input type="text" name="${itemName}['${itemKey}'][title]" value="" placeholder="sosyal medya başlık" />
            <input type="text" name="${itemName}['${itemKey}'][icon]" value="" placeholder="icon kodu" />
            <input type="text" name="${itemName}['${itemKey}'][link]" value="" placeholder="sosyal medya link" />
            <span class="btn-delete-item"><span class="dashicons dashicons-trash"></span></span>
          </section>`;
        $(e.target).prev('.wrap-items').append(item);
      });

      // HOME NAVIGATION -custom-id
      $('#panel_home_navigation').on('click', '.btn-new-item', function(e){
        var itemName = 'setting_home_navigation'; // Custom Name Value
        var itemKey = Date.now();
        var item = `<section class="ui-sortable-handle">
          <span class="move-btn dashicons dashicons-sort"></span>
          <input type="text" name="${itemName}['${itemKey}'][title]" value="" placeholder="Yazı" />
          <input type="text" name="${itemName}['${itemKey}'][icon]" value="" placeholder="Resim veya Icon kodu" />
          <input type="text" name="${itemName}['${itemKey}'][link]" value="" placeholder="Link" />
          <span class="btn-delete-item"><span class="dashicons dashicons-trash"></span></span>
        </section>`;
        $(e.target).prev('.wrap-items').append(item);
      });

    });
  </script>

<?php 
}