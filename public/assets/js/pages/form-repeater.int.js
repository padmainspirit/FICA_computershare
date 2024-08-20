/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************************!*\
  !*** ./resources/js/pages/form-repeater.int.js ***!
  \*************************************************/
  $(document).ready(function () {
    "use strict";

    function showConfirmationModal(callback) {
      var modalHtml = `
        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Are you sure you want to delete this element?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
              </div>
            </div>
          </div>
        </div>
      `;
      $("body").append(modalHtml);
      var modal = new bootstrap.Modal(document.getElementById('confirmationModal'), {});
      modal.show();

      $("#confirmDelete").on("click", function () {
        callback(true);
        modal.hide();
        $("#confirmationModal").remove(); // Clean up
      });

      $("#confirmationModal").on("hidden.bs.modal", function () {
        callback(false);
        $("#confirmationModal").remove(); // Clean up
      });
    }

    $(".repeater").repeater({
      defaultValues: {
        "textarea-input": "foo",
        "text-input": "bar",
        "select-input": "B",
        "checkbox-input": ["A", "B"],
        "radio-input": "B"
      },
      show: function show() {
        var limitcount = $(this).parents(".repeater").data("limit");
        var itemcount = $(this).parents(".repeater").find("div[data-repeater-item]").length;
        if (limitcount) {
          if (itemcount <= limitcount) {
            $(this).slideDown();
          } else {
            $(this).remove();
          }
        } else {
          $(this).slideDown();
        }

        if (itemcount >= limitcount) {
          $(".repeater p[data-repeater-create]").hide("slow");
        }
      },
      hide: function hide(e) {
        var limitcount = $(this).parents(".repeater").data("limit");
        var itemcount = $(this).parents(".repeater").find("div[data-repeater-item]").length;

        showConfirmationModal(function (confirmed) {
          if (confirmed) {
            $(e).slideUp();
          }
          if (limitcount) {
            if (itemcount <= limitcount) {
              $(".repeater p[data-repeater-create]").show("slow");
            }
          }
        });
      },
      ready: function ready(e) {}
    }), window.outerRepeater = $(".outer-repeater").repeater({
      defaultValues: {
        "text-input": "outer-default"
      },
      show: function show() {
        console.log("outer show"), $(this).slideDown();
      },
      hide: function hide(e) {
        console.log("outer delete"), $(this).slideUp(e);
      },
      repeaters: [{
        selector: ".inner-repeater",
        defaultValues: {
          "inner-text-input": "inner-default"
        },
        show: function show() {
          console.log("inner show"), $(this).slideDown();
        },
        hide: function hide(e) {
          console.log("inner delete"), $(this).slideUp(e);
        }
      }]
    });

});
/******/ })()
;
