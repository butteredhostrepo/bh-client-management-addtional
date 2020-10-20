Dropzone.autoDiscover = false;

jQuery(document).ready(function () {
  ///ADD NOTES
  //jQuery("#addNotes #media-uploader").dropzone({

  if (jQuery("#media-uploader").length) {
    ////to prevent invalid dropzone element

    var add_Note_File = new Dropzone("#addNotes #media-uploader", {
      url: "/wp-admin/admin-ajax.php?action=handle_dropped_media",
      params: {
        client: jQuery("#addNotes #add_note_client").val(),
        note: jQuery("#addNotes .update_note").val(),
      },
      maxFilesize: 2, //2mb
      parallelUploads: 1,
      init: function () {
        this.on("complete", function (file) {
          if (
            this.getUploadingFiles().length === 0 &&
            this.getQueuedFiles().length === 0
          ) {
            jQuery("#addNotes .btn").prop("disabled", false);
            jQuery("#addNotes .upload_status").html("");
          }
        });
      },

      acceptedFiles:
        "image/jpeg,image/png,image/gif,application/docx,application/pdf,text/plain,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document",
      dictDefaultMessage: "Drop files here or click to upload.",
      sending: function () {
        jQuery("#addNotes .btn").prop("disabled", true);
        jQuery("#addNotes .upload_status").html("Uploading...");
      },
      success: function (file, response) {
        console.log(response);
        file.previewElement.classList.add("dz-success");
        file["attachment_id"] = response.data.media; // push the id for future reference
        var ids = jQuery("#media-ids").val() + "," + response.data.media;
        jQuery("#addNotes #media-ids").val(ids);

        jQuery(".update_note").attr("value", response.data.note);
        jQuery("#addNotes #action").val("update_client_notes");

        this.options.params = {
          client: jQuery("#addNotes #add_note_client").val(),
          note: jQuery("#addNotes .update_note").val(),
        };
      },
      error: function (file, response) {
        alert(response);
        jQuery("#addNotes .upload_status").html("Error: " + response);
        jQuery("#addNotes .btn").prop("disabled", false);
        console.log("Test: " + response);
        file.previewElement.classList.add("dz-error");
        return (_ref = file.previewElement) != null
          ? _ref.parentNode.removeChild(file.previewElement)
          : void 0;
      },
      // update the following section is for removing image from library
      addRemoveLinks: true,
      removedfile: function (file) {
        var attachment_id = file.attachment_id;
        jQuery.ajax({
          type: "POST",
          url: "/wp-admin/admin-ajax.php?action=deleted_media",
          data: {
            media_id: attachment_id,
          },
        });
        var _ref;
        return (_ref = file.previewElement) != null
          ? _ref.parentNode.removeChild(file.previewElement)
          : void 0;
      },
    });

    add_Note_File.hiddenFileInput.removeAttribute("multiple");

    //Update Notes

    jQuery("#updateNote #media-uploader").dropzone({
      url: "/wp-admin/admin-ajax.php?action=handle_dropped_media",
      params: {
        client: jQuery("#updateNote #add_note_client").val(),
        //  'note': $note_objects.note,
      },
      maxFilesize: 2, //2mb
      acceptedFiles:
        "image/jpeg,image/png,image/gif,application/docx,application/pdf,text/plain,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document",
      dictDefaultMessage: "Drop files here or click to upload.",
      sending: function (file, xhr, formData) {
        formData.append("note", jQuery("#updateNote .update-note").val()); //sends what note

        jQuery("#updateNote .btn").prop("disabled", true);
        jQuery("#updateNote .upload_status").html("Uploading...");
      },
      success: function (file, response) {
        console.log(response);
        file.previewElement.classList.add("dz-success");
        file["attachment_id"] = response.data.media; // push the id for future reference
        var ids =
          jQuery("#updateNote #media-ids").val() + "," + response.data.media;
        jQuery("#updateNote #media-ids").val(ids);

        jQuery("#updateNote .btn").prop("disabled", false);
        jQuery("#updateNote .upload_status").html("");

        jQuery("#updateNote .update_note").attr("value", response.data.note);
        // jQuery('#updateNote #action').val('update_client_notes');

        (this.options.params = {
          client: jQuery("#updateNote #add_note_client").val(),
          note: jQuery("#updateNote .update-note").val(),
        }),
          console.log(jQuery("#updateNote .update-note").val());
      },
      error: function (file, response) {
        jQuery("#updateNote .upload_status").html("Error: " + response);
        jQuery("#updateNote .btn").prop("disabled", false);
        file.previewElement.classList.add("dz-error");
        return (_ref = file.previewElement) != null
          ? _ref.parentNode.removeChild(file.previewElement)
          : void 0;
      },
      // update the following section is for removing image from library
      addRemoveLinks: true,
      removedfile: function (file) {
        var attachment_id = file.attachment_id;
        jQuery.ajax({
          type: "POST",
          url: "/wp-admin/admin-ajax.php?action=deleted_media",
          data: {
            media_id: attachment_id,
          },
        });
        var _ref;
        return (_ref = file.previewElement) != null
          ? _ref.parentNode.removeChild(file.previewElement)
          : void 0;
      },
    });
  }

  //jQuery("#updateNote #media-uploader").dd;
});
