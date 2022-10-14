$(function () {

    $.fn.filepond.registerPlugin(
        FilePondPluginImageExifOrientation,
        FilePondPluginImagePreview,
        FilePondPluginImageCrop,
        FilePondPluginImageResize,
        FilePondPluginImageEdit);
    let pond = FilePond.create(document.getElementById("filepond_input"), {});
    let profile_pond = FilePond.create(document.getElementById("profile"), {
        labelIdle: `Drag & Drop your picture or <span class="filepond--label-action">Browse</span>`,
        imagePreviewHeight: 170,
        imageCropAspectRatio: '1:1',
        imageResizeTargetWidth: 200,
        imageResizeTargetHeight: 200,
        stylePanelLayout: 'compact circle',
        styleLoadIndicatorPosition: 'center bottom',
        styleProgressIndicatorPosition: 'right bottom',
        styleButtonRemoveItemPosition: 'left bottom',
        styleButtonProcessItemPosition: 'right bottom',
        });
    $('#filepond_form_submit').click(function (e) {
        e.preventDefault();
        let formData = new FormData($("#filepond_form")[0]);
        formData.delete("filepond_input");
        formData.delete("profile");
        $.each(pond.getFiles(), function (i, file) {
            formData.append('files[]',file.file);
        });

        $.each(profile_pond.getFiles(), function (i, file) {
            formData.append('profile',file.file);
        });
        
        $.ajax({
            url: "form_post.php",
            type: "POST",
            processData: false,
            contentType: false,
            data: formData,
            success: function (d) {
                console.log(d);
                return false;
            }
        });
        return false;
    });
});