<style>
    :root {
        --main-color-one: {{get_static_option('site_color')}};
        --secondary-color: {{get_static_option('site_secondary_color')}};
        --heading-color: {{get_static_option('site_heading_color')}};
        --special-color: {{get_static_option('site_special_color')}};
        --paragraph-color: {{get_static_option('site_paragraph_color')}};
        --form-bg-color: {{get_static_option('site_form_bg_color')}};
        --footer-bg-color: {{get_static_option('site_footer_bg_color')}};
        @php $heading_font_family = !empty(get_static_option('heading_font')) ? get_static_option('heading_font_family') :  get_static_option('body_font_family') @endphp
        --heading-font: "{{$heading_font_family}}",sans-serif;
        --body-font:"{{get_static_option('body_font_family')}}",sans-serif;
        --extra-font: @php echo get_static_option('extra_font_family') @endphp, serif;
    }

</style>