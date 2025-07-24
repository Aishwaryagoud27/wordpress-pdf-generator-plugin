<?php

class PDF_Generator {

    public function run() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_filter('the_content', [$this, 'add_pdf_button']);
        add_action('init', [$this, 'handle_pdf_request']);
    }

    public function enqueue_assets() {
        wp_enqueue_style('pdf-generator-style', plugin_dir_url(__FILE__) . '../assets/css/style.css');
    }

    public function add_pdf_button($content) {
        if (is_single()) {
            $button = '<a class="pdf-download-btn" href="' . esc_url(add_query_arg('download_pdf', get_the_ID())) . '" target="_blank">📄 Download PDF</a>';
            return $button . $content;
        }
        return $content;
    }

    public function handle_pdf_request() {
        if (isset($_GET['download_pdf'])) {
            $post_id = intval($_GET['download_pdf']);
            $this->generate_pdf($post_id);
            exit;
        }
    }

    public function generate_pdf($post_id) {
        require_once plugin_dir_path(__FILE__) . '../vendor/autoload.php';

        $post = get_post($post_id);
        $html = '<h1>' . esc_html($post->post_title) . '</h1>';
        $html .= wpautop($post->post_content);

        $pdf = new \Mpdf\Mpdf();
        $pdf->WriteHTML($html);
        $pdf->Output('document.pdf', 'I');
    }
}
