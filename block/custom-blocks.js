// console.log('GLOBALs', HHGSUN_JS_GLOBAL);
// HHGSUN_JS_GLOBAL.theme_path -> theme url

//https://wp-gb.com/  -> block examples

(function (blocks, element, i18n) {
  const __ = i18n.__;
  const el = element.createElement;

  const {
    InnerBlocks,
    InspectorControls,
    RichText,
    MediaUpload
  } = wp.blockEditor;

  const {
    Button,
    PanelBody,
    PanelRow,
    CheckboxControl,
    SelectControl,
    ColorPicker,
    ColorPalette,
    ToggleControl,
    TextControl,
  } = wp.components;


  // Custom Colors
  const ColorPaletteVelues = [
    { name: 'blue', color: '#0d6efd' },
    { name: 'indigo', color: '#6610f2' },
    { name: 'purple', color: '#6f42c1' },
    { name: 'pink', color: '#d63384' },
    { name: 'red', color: '#dc3545' },
    { name: 'orange', color: '#fd7e14' },
    { name: 'yellow', color: '#ffc107' },
    { name: 'green', color: '#198754' },
    { name: 'teal', color: '#20c997' },
    { name: 'cyan', color: '#0dcaf0' },
    { name: 'white', color: '#fff' },
    { name: 'gray', color: '#6c757d' },
    { name: 'gray-dark', color: '#343a40' },
    { name: 'light', color: '#f8f9fa' },
    { name: 'dark', color: '#212529' },
  ]

  // Get Categories
  const categorySelections = [];
  const allCategories = wp.apiFetch({ path: "/wp/v2/categories" }).then(cats => {
    categorySelections.push({ label: "Select a Category", value: 0 });
    cats.forEach(cat => {
      categorySelections.push({ label: cat.name, value: cat.id });
    });
    return categorySelections;
  });


  /*************************************************************
   * SLIDES WRAP BLOCK
   */
  blocks.registerBlockType('hhgsun/slides', {
    title: 'Slides Wrapper',
    icon: "format-gallery",
    category: 'hhgsun-block',
    attributes: {
      bgColor: { type: 'string' }
    },
    edit: function (props) {
      return [
        el(InspectorControls, {},
          el(PanelBody, {
            title: "Colors"
          }, [
            el(ColorPalette, {
              colors: ColorPaletteVelues,
              value: props.attributes.bgColor,
              onChange: function (val) {
                props.setAttributes({ bgColor: val });
              }
            }),
            el(ColorPicker, {
              color: props.attributes.bgColor ?? "#0d6efd",
              onChangeComplete: function (val) {
                props.setAttributes({ bgColor: val.hex });
              }
            }),
          ]),
        ),
        el(
          'div',
          { className: props.className, style: { backgroundColor: props.attributes.bgColor, padding: "10px 20px 20px 20px" } },
          el('h3', {}, "Slides:"),
          el(InnerBlocks, { allowedBlocks: ['hhgsun/hero-item'] })
        )
      ];
    },
    save: function (props) {
      return el(
        'div',
        { className: "hero-slides owl-carousel", style: { backgroundColor: props.attributes.bgColor } },
        el(InnerBlocks.Content)
      );
    },
  });
  /* .. end block */

  /*************************************************************
   * HERO ITEM BLOCK
   */
  blocks.registerBlockType('hhgsun/hero-item', {
    title: 'Hero Item',
    icon: 'format-image',
    category: 'hhgsun-block',
    parent: ['hhgsun/slides'],
    attributes: {
      title: { type: 'string' },
      desc: { type: 'string' },
      mediaUrl: { type: 'string' },
      buttonText: { type: 'string' },
      buttonUrl: { type: 'string' },
      bgColor: { type: 'string' },
    },
    edit: function (props) {
      return [
        el(InspectorControls, {},
          el(PanelBody, {
            title: "Button"
          }, [
            el(TextControl, {
              label: "Button Text",
              value: props.attributes.buttonText,
              onChange: function (val) {
                props.setAttributes({ buttonText: val });
              }
            }),
            el(TextControl, {
              label: "Button Url",
              value: props.attributes.buttonUrl,
              onChange: function (val) {
                props.setAttributes({ buttonUrl: val });
              }
            }),
          ]),
          el(PanelBody, {
            title: "Colors"
          }, [
            el(ColorPalette, {
              colors: ColorPaletteVelues,
              value: props.attributes.bgColor,
              onChange: function (val) {
                props.setAttributes({ bgColor: val });
              }
            }),
          ]),
        ),
        el("div", { style: { backgroundColor: props.attributes.bgColor, border: "1px solid gray", padding: "5px 10px" } },
          el(RichText, {
            tagName: 'h2',
            inline: true,
            placeholder: __('Title'),
            value: props.attributes.title,
            onChange: function (value) {
              props.setAttributes({ title: value });
            },
          }),
          el(RichText, {
            tagName: 'p',
            placeholder: __('Description'),
            value: props.attributes.desc,
            onChange: function (value) {
              props.setAttributes({ desc: value });
            },
          }),
          el(MediaUpload, {
            onSelect: function (media) {
              console.log(media, media.sizes.full.url);
              props.setAttributes({ mediaUrl: media.sizes.full.url });
            },
            type: 'button',
            className: 'components-button editor-media-placeholder__button is-button is-default is-large',
            value: props.attributes.mediaUrl,
            render: function (obj) {
              return [
                el("img", { src: props.attributes.mediaUrl, style: { height: "200px", }, }),
                el(Button, {
                  className: 'components-button editor-media-placeholder__button is-button is-default is-large',
                  onClick: obj.open,
                  children: props.attributes.mediaUrl ? __('Resmi Güncelle') : __('Resim Ekle'),
                })
              ];
            }
          }),
        )
      ];
    },
    save: function (props) {
      return el("article", { className: "container col-xxl-8 px-4 py-2 post-85", style: { backgroundColor: props.attributes.bgColor } },
        el("div", { className: "row flex-lg-row-reverse align-items-center g-5 py-5" },
          el("div", { className: "col-10 col-sm-8 col-lg-6" },
            el("img", { src: props.attributes.mediaUrl, className: "d-block mx-lg-auto img-fluid", alt: props.attributes.title, loading: "lazy" }),
          ),
          el("div", { className: "col-lg-6" },
            el(RichText.Content, { tagName: 'h2', className: "display-5 fw-bold lh-1 mb-3", value: props.attributes.title }),
            el(RichText.Content, { tagName: 'p', className: "lead", value: props.attributes.desc }),
            props.attributes.buttonText ?
              el("div", { className: "d-grid gap-2 d-md-flex justify-content-md-start" },
                el("a", { href: props.attributes.buttonUrl, className: "btn btn-primary btn-lg px-4 me-md-2", title: props.attributes.title }, props.attributes.buttonText),
              ) : '',
          ),
        ),
      );
    }
  });
  /* .. end block */

  /*************************************************************
   * CONTAINER BLOCK
   */
  blocks.registerBlockType('hhgsun/container', {
    title: 'Container',
    icon: "align-wide",
    category: 'hhgsun-block',
    attributes: {
      bgColor: { type: 'string' },
      fluid: { type: 'Boolean' },
      size: { type: 'string' }
    },
    edit: function (props) {
      return [
        el(InspectorControls, {},
          el(PanelBody, {
            title: __('Fluid')
          },
            el(PanelRow, {},
              el(SelectControl,
                {
                  label: 'Size',
                  value: props.attributes.size,
                  options: [
                    { label: 'Az Genişlik', value: 'container container-half' },
                    { label: 'Orta Genişlik', value: 'container' },
                    { label: 'Tam Genişlik', value: 'container-fluid' },
                  ],
                  onChange: function (val) {
                    props.setAttributes({ size: val })
                  }
                }
              ),
            ),
          ),
          el(PanelBody, {
            title: __('Background')
          },
            el(ColorPalette, {
              colors: ColorPaletteVelues,
              value: props.attributes.bgColor,
              onChange: function (val) {
                props.setAttributes({ bgColor: val });
              }
            })
          ),
        ),
        el(
          'div',
          { className: props.className, style: { backgroundColor: props.attributes.bgColor, padding: "10px" } },
          el(InnerBlocks)
        )
      ];
    },
    save: function (props) {
      return el(
        'div',
        { className: props.attributes.size, style: { background: props.attributes.bgColor } },
        el(InnerBlocks.Content)
      );
    },
  });
  /* .. end block */

})(
  window.wp.blocks,
  window.wp.element,
  window.wp.i18n
);

