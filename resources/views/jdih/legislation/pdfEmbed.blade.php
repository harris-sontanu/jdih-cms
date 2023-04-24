<script src="https://documentservices.adobe.com/view-sdk/viewer.js"></script>
<script type="text/javascript">
    document.addEventListener("adobe_dc_view_sdk.ready", function(){
        var adobeDCView = new AdobeDC.View({clientId: "{{ $adobeKey }}", divId: "{{ $el }}"});
        const article = document.querySelector("#{{ $el }}");
        adobeDCView.previewFile({
            content:{ location:
            { url: article.dataset.file }},
            metaData:{fileName: article.dataset.name}
        },
        {
            embedMode: "SIZED_CONTAINER",
            showDownloadPDF: false,
            showPrintPDF: false
        });
    });
</script>