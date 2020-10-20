(function ($) {
  "use strict";

  //**Bootstrap form valdiation */
  window.addEventListener(
    "load",
    function () {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName("needs-validation");
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener(
          "submit",
          function (event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add("was-validated");
          },
          false
        );
      });
    },
    false
  );
  //**END Bootstrap form valdiation */

  /**
   * All of the code for your public-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */

  $(document).ready(function () {
    /*HACKS*/
    /*$("li.client-form a").attr(
      "href",
      $("li.client-form a").attr("href") + "#profile|1"
    );*/

    $(".datepicker").datepicker({
      dateFormat: "yy-mm-dd",
    });

    $(".datepicker_birth").datepicker({
      dateFormat: "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      yearRange: "-120:+0",
    });

    //for date range
    $("#from, #to").datepicker({
      beforeShow: customRange,
      dateFormat: "yy-mm-dd",
    });

    function customRange(input) {
      if (input.id == "to") {
        var minDate = new Date($("#from").val());
        minDate.setDate(minDate.getDate() + 1);

        return {
          minDate: minDate,
        };
      }
      return {};
    }
    //end for date range

    ///for alert close button
    $(".alert .close").click(function () {
      var $current_url = window.location.href;
      var $currrent_hash = window.location.hash;

      var $new_url = removeParam("addednote", $current_url);
      var $new_url = removeParam("updatednote", $new_url);
      var $new_url = removeParam("err", $new_url);
      var $new_url = removeParam("updated", $new_url);
      var $new_url = removeParam("added", $new_url);
      var $new_url = removeParam("updated_referral", $new_url);
      var $new_url = removeParam("updated_risk", $new_url);

      window.history.pushState("page2", "Title", $new_url + $currrent_hash);
    });
    ///END for alert close button

    //for view/update client's note

    $("a.btn-updateNote").click(function () {
      $(".note-update-form").hide();
      $(".view-note-details").hide();

      $("#updateNote .form-content-status").show();
      $("#viewNote .form-content-status").show();

      var $nonce = jQuery(this).data("nonce");
      var $note = jQuery(this).data("note");
      var $view = jQuery(this).data("view");

      jQuery.ajax({
        type: "post",
        dataType: "json",
        url: "/wp-admin/admin-ajax.php",
        data: { action: "get_note", nonce: $nonce, note: $note, view: $view },
        success: function (response) {
          //updateform
          jQuery("#updateNote #date_session_update").val(
            response.data.session_date
          );
          jQuery("#updateNote #note").val(
            response.data.note.replace(/(<([^>]+)>)/gi, "")
          );
          // jQuery("#updateNote #update-note").val(response.data.id);
          jQuery("#updateNote .update-note").attr("value", response.data.id);
          jQuery("#updateNote #note_files_view").html(response.data.files);

          if (response.data.dna == 1) {
            jQuery("#dna_yes").attr("checked", "checked");
          } else {
            jQuery("#dna_no").attr("checked", "checked");
          }

          //view
          console.log(response);
          jQuery("#viewNote #date_session_view").html(
            response.data.session_date
          );
          jQuery("#viewNote #note_view").html(response.data.note);
          jQuery("#viewNote #note_files_view").html(response.data.files);

          if (response.data.dna == 1) {
            jQuery("#viewNote #dna").html("Yes");
          } else {
            jQuery("#viewNote #dna").html("No");
          }

          $(".note-update-form").show();
          $(".view-note-details").show();

          $("#updateNote .form-content-status").hide();
          $("#viewNote .form-content-status").hide();
        },
      });
    });

    $(document).on("click", "a.note-remove-file", function () {
      var file = $(this).data("file");
      var $this = $(this);

      jQuery.ajax({
        type: "post",
        dataType: "json",
        url: "/wp-admin/admin-ajax.php",
        data: {
          action: "deleted_media",
          media_id: file,
        },
        success: function (response) {
          $this.parent().remove();
          //location.reload();
        },
      });

      return false;
    });

    //END for view/update client's note

    //for delete client's note
    $("a.btn-deleteNote").click(function () {
      var $nonce = jQuery(this).data("nonce");
      var $note = jQuery(this).data("note");

      $(".delete-note").data("nonce", $nonce);
      $(".delete-note").data("note", $note);
    });

    $(".delete-note").click(function () {
      var $nonce = jQuery(this).data("nonce");
      var $note = jQuery(this).data("note");

      jQuery.ajax({
        type: "post",
        dataType: "json",
        url: "/wp-admin/admin-ajax.php",
        data: {
          action: "delete_note",
          nonce: $nonce,
          note: $note,
        },
        success: function (response) {
          location.reload();
        },
      });
    });
    //END for delete client's note

    //for Forms/assign forms
    $(".assign_form_client").click(function () {
      $(this).html("Assigning..");

      var $nonce = jQuery(this).data("nonce");
      var $form = jQuery(this).data("form");
      var $client = jQuery(this).data("client");

      jQuery.ajax({
        type: "post",
        dataType: "json",
        url: "/wp-admin/admin-ajax.php",
        data: {
          action: "assign_form",
          nonce: $nonce,
          form: $form,
          client: $client,
        },
        success: function (response) {
          location.reload();
        },
      });
    });
    //END for Forms/assign forms

    //for Forms/unassign forms
    $(".unassign_form_client").click(function () {
      $(this).html("Removing..");

      var $nonce = jQuery(this).data("nonce");
      var $form = jQuery(this).data("form");
      var $client = jQuery(this).data("client");

      jQuery.ajax({
        type: "post",
        dataType: "json",
        url: "/wp-admin/admin-ajax.php",
        data: {
          action: "unassign_form",
          nonce: $nonce,
          form: $form,
          client: $client,
        },
        success: function (response) {
          location.reload();
        },
      });
    });
    //END for Forms/unassign forms

    //for view/update client's DONATION
    $("a.btn-update_donation").click(function () {
      $(".donation-update-form").hide();
      $(".view-donation-details").hide();

      $(".note-loading").show();

      var $nonce = jQuery(this).data("nonce");
      var $donation = jQuery(this).data("donation");

      jQuery.ajax({
        type: "post",
        dataType: "json",
        url: "/wp-admin/admin-ajax.php",
        data: { action: "get_donation", nonce: $nonce, donation: $donation },
        success: function (response) {
          //updateform
          jQuery("#update_donation #dateofdonation").val(response.data.date);
          jQuery("#update_donation #donation_amount").val(response.data.amount);
          jQuery("#update_donation #note").val(
            response.data.note.replace(/(<([^>]+)>)/gi, "")
          );
          jQuery("#update_donation #update-donation").val(response.data.id);

          if (response.data.type == "cash")
            jQuery("#update_donation #type_cash").attr("checked", "checked");
          else jQuery("#update_donation #type_bank").attr("checked", "checked");

          if (response.data.gift_aid == "yes")
            jQuery("#update_donation #gift_yes").attr("checked", "checked");
          else jQuery("#update_donation #gift_no").attr("checked", "checked");

          //view
          jQuery("#view_donation #date_donation").html(response.data.date);
          jQuery("#view_donation #donation_amount").html(response.data.amount);
          jQuery("#view_donation #donation_note_view").html(response.data.note);
          jQuery("#view_donation #donation_type").html(response.data.type);
          jQuery("#view_donation #gift_aid").html(response.data.gift_aid);

          $(".donation-update-form").show();
          $(".view-donation-details").show();

          $(".note-loading").hide();
        },
      });
    });

    //END for view/update client's DONATION

    //for delete client's donation
    $("a.btn-delete_donation").click(function () {
      var $nonce = jQuery(this).data("nonce");
      var $donation = jQuery(this).data("donation");

      $(".delete-donation-confirmed").data("nonce", $nonce);
      $(".delete-donation-confirmed").data("donation", $donation);
    });

    $(".delete-donation-confirmed").click(function () {
      var $nonce = jQuery(this).data("nonce");
      var $donation = jQuery(this).data("donation");

      jQuery.ajax({
        type: "post",
        dataType: "json",
        url: "/wp-admin/admin-ajax.php",
        data: {
          action: "delete_donation",
          nonce: $nonce,
          donation: $donation,
        },
        success: function (response) {
          location.reload();
        },
      });
    });

    //END for delete client's donation

    //for counsellor's availability day toggle
    $(".day").change(function () {
      if ($(this).is(":checked")) {
        $(this).parent().find(".day-hide").show();
      } else {
        $(this).parent().find(".day-hide").hide();
      }
    });

    //ENDfor counsellor's availability day toggle

    //for view/update client's RISK REPORT
    $("a.btn-update_risk_report").click(function () {
      $(".risk_report-update-form").hide();
      $(".view-risk_report-details").hide();

      $(".note-loading").show();

      var $nonce = jQuery(this).data("nonce");
      var $risk_report = jQuery(this).data("risk_report");

      jQuery.ajax({
        type: "post",
        dataType: "json",
        url: "/wp-admin/admin-ajax.php",
        data: {
          action: "get_risk_report",
          nonce: $nonce,
          risk_report: $risk_report,
        },
        success: function (response) {
          //console.log(response);
          $(".risk_report-update-form").show();
          $(".view-risk_report-details").show();

          var data = JSON.parse(JSON.stringify(response.data.risk_report));
          //Update
          $("#update_risk_report #risk_report_date").val(data.risk_report_date);
          $("#update_risk_report #nature_concern").val(data.nature_concern);
          $("#update_risk_report #you_did").val(data.you_did);
          $("#update_risk_report #told_you").val(data.told_you);
          $("#update_risk_report #outcome").val(data.outcome);
          $("#update_risk_report #action").val("update_risk_report");
          $("#update_risk_report #mid").val($risk_report);

          $('#update_risk_report [type="checkbox"]').attr("checked", false);

          data.action_taken.forEach(function (value, index, array) {
            var checkboxId = value.replace(/\s/g, "");
            $("#update_risk_report #" + checkboxId).attr("checked", true);
          });

          //VIEW
          $("#view_risk_report #risk_report_date").html(data.risk_report_date);
          $("#view_risk_report #nature_concern").html(data.nature_concern);
          $("#view_risk_report #you_did").html(data.you_did);
          $("#view_risk_report #told_you").html(data.told_you);
          $("#view_risk_report #outcome").html(data.outcome);

          var action_taken_html = "";

          data.action_taken.forEach(function (value, index, array) {
            action_taken_html += value + "<br>";
          });

          $("#view_risk_report #action_taken").html(action_taken_html);

          $(".note-loading").hide();
        },
      });
    });

    //END for view/update client's RISK REPORT

    //for delete client's RISK REPORT
    $("a.btn-delete_risk_report").click(function () {
      var $nonce = jQuery(this).data("nonce");
      var $risk_report = jQuery(this).data("risk_report");

      $(".delete-risk_report-confirmed").data("nonce", $nonce);
      $(".delete-risk_report-confirmed").data("risk_report", $risk_report);
    });

    $(".delete-risk_report-confirmed").click(function () {
      var $nonce = jQuery(this).data("nonce");
      var $risk_report = jQuery(this).data("risk_report");

      jQuery.ajax({
        type: "post",
        dataType: "json",
        url: "/wp-admin/admin-ajax.php",
        data: {
          action: "delete_risk_report",
          nonce: $nonce,
          risk_report: $risk_report,
        },
        success: function (response) {
          location.reload();
        },
      });
    });

    //UTILS
    //for popover
    $(".popover-dismiss").popover({
      trigger: "hover",
    });

    //@ for alert close button
    function removeParam(key, sourceURL) {
      var rtn = sourceURL.split("?")[0],
        param,
        params_arr = [],
        queryString =
          sourceURL.indexOf("?") !== -1 ? sourceURL.split("?")[1] : "";
      if (queryString !== "") {
        params_arr = queryString.split("&");
        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
          param = params_arr[i].split("=")[0];
          if (param === key) {
            params_arr.splice(i, 1);
          }
        }
        rtn = rtn + "?" + params_arr.join("&");
      }
      return rtn;
    }

    jQuery(".swipebox").swipebox();
  });
})(jQuery);
