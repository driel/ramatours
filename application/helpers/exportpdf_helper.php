<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('get_pdf_header')) {

    function get_pdf_header() {
        $header =
"<html lang=\"en\">
<head>
<meta charset=\"utf-8\">
<title>PDF</title>
<link rel=\"stylesheet\" type=\"text/css\" href=\"http://localhost/payroll/assets/application.css\"/>
<link rel=\"stylesheet\" type=\"text/css\" href=\"http://localhost/payroll/assets/css/fullcalendar.css\"/>
<link rel=\"stylesheet\" type=\"text/css\" href=\"http://localhost/payroll/assets/css/stylesheets.css\" media=\"all\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"http://localhost/payroll/assets/css/dashboard.css\" media=\"all\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"http://localhost/payroll/assets/css/bootstrapSwitch.css\" media=\"all\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"http://localhost/payroll/assets/css/jquery.alerts.css\" media=\"all\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"http://localhost/payroll/assets/css/iphone-style.css\" media=\"all\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"http://localhost/payroll/assets/css/mcustomscrollbar/mCustomScrollbar.css\" media=\"all\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"http://localhost/payroll/assets/css/jquery.handsontable.full.css\" media=\"all\" />
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/plugins/jquery/jquery-1.9.1.min.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/plugins/jquery/jquery-ui-1.10.1.custom.min.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/plugins/jquery/jquery-migrate-1.1.1.min.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/plugins/jquery/globalize.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/plugins/other/excanvas.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/plugins/other/jquery.mousewheel.min.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/plugins/bootstrap/bootstrap.min.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/bootstrap-modal.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/bootstrap-modalmanager.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/bootstrapSwitch.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/plugins/cookies/jquery.cookies.2.2.0.min.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/plugins/validationEngine/languages/jquery.validationEngine-en.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/plugins/validationEngine/jquery.validationEngine.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/plugins/uniform/jquery.uniform.min.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/plugins/select/select2.min.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/plugins/maskedinput/jquery.maskedinput-1.3.min.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/colResizable-1.3.med.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/jquery.alerts.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/iphone-style-checkboxes.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/jquery.editable-1.3.3.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/jquery.number.min.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/jquery.handsontable.full.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/plugins/jquery.jstree.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/accounting.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/plugins.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/actions.js\"></script>
<script type=\"text/javascript\" src=\"http://localhost/payroll/assets/js/custom.js\"></script>
<script src=\"http://localhost/payroll/assets/js/fullcalendar/fullcalendar.js\" type=\"text/javascript\"></script>
<script src=\"http://localhost/payroll/assets/js/fullcalendar/fullcalendar.min.js\" type=\"text/javascript\"></script>                
<link rel=\"stylesheet\" type=\"text/css\" href=\"http://localhost/payroll/assets/docs.css\"/>
</head>
<body>";
		return $header;
    }

}