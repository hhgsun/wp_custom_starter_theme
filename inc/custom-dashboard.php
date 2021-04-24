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
  register_setting( 'theme_settings_group_data', 'setting_all_socialmedia' );

  register_setting( 'theme_settings_group_data', 'setting_extracode' );

  register_setting( 'theme_settings_group_data', 'setting_yapim_asamasinda' );
  register_setting( 'theme_settings_group_data', 'setting_yapim_asamasinda_url' );

  register_setting( 'theme_settings_group_data', 'setting_ozelbolum_cat' );
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

      <details id="setting_all_socialmedia">
        <summary>Sosyal Medya Hesapları</summary>
        <div class="wrap-items">
          <?php if(get_option('setting_all_socialmedia')) {
            foreach (get_option('setting_all_socialmedia') as $key => $value) {
              $social_title = isset($value['title']) ? esc_attr( $value['title'] ) : '';
              $social_icon = isset($value['icon']) ? esc_attr( $value['icon'] ) : '';
              $social_link = isset($value['link']) ? esc_attr( $value['link'] ) : '';
              ?>
              <section class="ui-sortable-handle">
                <span class="move-btn dashicons dashicons-sort"></span>
                <input type="text" name="setting_all_socialmedia[<?php echo $key; ?>][title]" value="<?php echo $social_title; ?>" placeholder="Sosyal medya başlık" />
                <input type="text" name="setting_all_socialmedia[<?php echo $key; ?>][icon]" value="<?php echo $social_icon; ?>" placeholder="İcon kodu" />
                <input type="text" name="setting_all_socialmedia[<?php echo $key; ?>][link]" value="<?php echo $social_link; ?>" placeholder="Sosyal medya link" />
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
      </details><!-- #setting_all_socialmedia -->


      <details>
        <summary>Ekstra Kod</summary>
        <?php
        $extracode = get_option('setting_extracode');
        $extracode_head = isset($extracode['head']) ? $extracode['head'] : '';
        $extracode_foot = isset($extracode['foot']) ? $extracode['foot'] : '';
        ?>
        <section>
          Header içi Kod
          <textarea rows="4" cols="50" name="setting_extracode[head]" style="width:80%;" placeholder="header'a javascript veya css kodu"><?php echo $extracode_head; ?></textarea>
        </section>
        <section>
          Footer içi Kod
          <textarea rows="4" cols="50" name="setting_extracode[foot]" style="width:80%;" placeholder="footer'a javascript veya css kodu"><?php echo $extracode_foot; ?></textarea>
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
          Özel Bölge İçin Bir Kategori:
          <?php wp_dropdown_categories( array(
            'show_option_none' => 'Özel Bölge için kategori seçin',
            'hide_empty' => 0,
            'name' => 'setting_ozelbolum_cat',
            'selected' => get_option('setting_ozelbolum_cat')
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

      // DELETE ITEM
      $(document).on('click', '.btn-delete-item', function(){
        var sor = confirm('Kaldırmak istediğinize eminmisiniz?');
        if(sor){
          var itemParent = $(this).parent()[0];
          itemParent.remove();
        }
      });

      /**********
       * ADD ITEMs (sadece 2 yer değiştirilmesi yeterli: ana div id si ve itemName)
       */

      // SOCIAL MEDIA -custom-id
      $('#setting_all_socialmedia').on('click', '.btn-new-item', function(e){
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

    });
  </script>

<?php 
}