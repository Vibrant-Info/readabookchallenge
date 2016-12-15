 <script type="text/javascript" src="<?php echo base_url()."plugins/googlePdfViewer/gdl-scripts.js" ;?>"></script>  

<script type="text/javascript" src="<?php echo base_url()."plugins/googlePdfViewer/jquery.gdocsviewer.min.js" ;?>"></script>

<script>	
$j(document).ready(function() {
    $('a.embed').gdocsViewer({width: 1000, height: 700});
});
</script>

<!-- <a href="<?php echo $pdf_link; ?>" class="embed" style="text-align : center; display : block;"></a> -->
<a href="<?php echo trim($pdf_link); ?>" class="embed" style="text-align : center; display : block;"></a>