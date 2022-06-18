$(document).ready(function () {
  toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: false,
    progressBar: false,
    positionClass: "toast-top-right",
    preventDuplicates: false,
    showDuration: "1000",
    hideDuration: "1000",
    timeOut: "5000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
  };
  //Check Image Size
  $("#image").bind("change", function () {
    $(".has_error").remove();
    $("#form-button").attr("type", "submit");
    var a = this.files[0].size;
    if (a > 1000000) {
      $(this).after(
        '<div class="text-danger has_error">Image size should be < 1MB</div>'
      );
      $("#form-button").attr("type", "button");
    }
  });
  $('#add_time').datetimepicker({
    datepicker:false,
    formatTime:"h:i a",
    step:60
 });
  $(document).on("click", ".update_variation", function () {
    var tr = $(this).closest("tr");
    $(".has_error").remove();
    var date = tr.find("input.date_concert").val();
    var price = tr.find("input.price").val();
    var county_id = tr.find("input.county_id").val();
    var pickup_id = tr.find("input.pickup_id").val();
    var product = tr.find("input.product").val();
    var formData = {
      date: date,
      price: price,
      county_id: county_id,
      pickup_id: pickup_id,
      product: product,
    };
    console.log(formData);
    $.ajax({
      method: "GET",
      url: $(this).data("action"),
      data: formData,
      success: function (response) {
        var data = JSON.parse(response);
        console.log(data);
        console.log(data.status);
        console.log(data.pickup_id);
        if (data.status === 400) {
          $("#price_" + data.pickup_id).after(
            '<div class="text-danger has_error">' + data.price + "</div>"
          );
        } else if (data.status === 500) {
          showError(data.msg);
        } else {
          //play();
          showSuccess(data.msg);
          if (data.redirect == true) {
            window.location.href = data.url;
          } else {
            location.reload();
          }
        }
        //$("#ajax-loader").hide();
      },
    }).fail(function (response, status, error) {
      var data = response.responseJSON;
      if (status === "error") {
        $.each(data.errors, function (i, val) {
          $("input[name=" + i + "]").after(
            '<div class="text-danger has_error">' + val + "</div>"
          );
          if ($("textarea[name=" + i + "]").length) {
            $("textarea[name=" + i + "]").after(
              '<div class="text-danger has_error">' + val + "</div>"
            );
          }
          if ($("select[name=" + i + "]").length) {
            $("select[name=" + i + "]").after(
              '<div class="text-danger has_error">' + val + "</div>"
            );
          }
          // if (i == "pick_point_id") {
          //   $(".pick_point_id_error").text(val);
          // }
          if (i == "pick_point_id" || i == "counties_id") {
            $(".error_" + i).text(val);
          }
        });
      }
    });
  });
  $(document).on("submit", "form[name=ajax_form]", function (e) {
    var formData = new FormData(this);
    e.preventDefault();
    $(".has_error").remove();
    $(".error-inline").text("");
    var fail = false;
    $(this)
      .find("select, textarea, input")
      .each(function () {
        if (!$(this).prop("required")) {
        } else {
          if (!$(this).val()) {
            fail = true;
            name = $(this).attr("name");
            $(this).after(
              '<div class="text-danger has_error">' +
                name +
                " is required</div>"
            );
          }
        }
      });
    if (!fail) {
      $.ajax({
        type: $(this).attr("method"),
        url: $(this).attr("action"),
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        // beforeSend: function () {
        //   $("#ajax-loader").show();
        // },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.status === 400) {
            $.each(data.error, function (i, val) {
              $("input[name=" + i + "]").after(
                '<div class="text-danger has_error">' + val + "</div>"
              );
              if ($("textarea[name=" + i + "]").length) {
                $("textarea[name=" + i + "]").after(
                  '<div class="text-danger has_error">' + val + "</div>"
                );
              }
              if ($("select[name=" + i + "]").length) {
                $("select[name=" + i + "]").after(
                  '<div class="text-danger has_error">' + val + "</div>"
                );
              }
            });
          } else if (data.status === 500) {
            showError(data.msg);
            // swal("Sorry!", data.msg, "error");
          } else {
            if ($(".modal").length) {
              $(".modal").modal("hide");
            }
            showSuccess(data.msg);

            setTimeout(() => {
              if (data.redirect == true) {
                window.location.href = data.url;
              } else {
                location.reload();
              }
            }, 1000);
          }
        },
      }).fail(function (response, status, error) {
        var data = response.responseJSON;
        if (status === "error") {
          $.each(data.errors, function (i, val) {
            $("input[name=" + i + "]").after(
              '<div class="text-danger has_error">' + val + "</div>"
            );
            if ($("textarea[name=" + i + "]").length) {
              $("textarea[name=" + i + "]").after(
                '<div class="text-danger has_error">' + val + "</div>"
              );
            }
            if ($("select[name=" + i + "]").length) {
              $("select[name=" + i + "]").after(
                '<div class="text-danger has_error">' + val + "</div>"
              );
            }
            // if (i == "pick_point_id") {
            //   $(".pick_point_id_error").text(val);
            // }
            if (i == "pick_point_id" || i == "counties_id") {
              $(".error_" + i).text(val);
            }
          });
        }
      });
    }
  });
  //Submit System Form
  $(document).on("submit", "form[name=ajax_form_system]", function (e) {
    var formData = new FormData(this);
    e.preventDefault();
    $(".has_error").hide();
    var fail = false;
    $(this)
      .find("select, textarea, input")
      .each(function () {
        if (!$(this).prop("required")) {
        } else {
          if (!$(this).val()) {
            fail = true;
            name = $(this).attr("name");
            $(this).after(
              '<div class="text-danger has_error">' +
                name +
                " is required</div>"
            );
          }
        }
      });
    if (!fail) {
      $.ajax({
        type: $(this).attr("method"),
        url: $(this).attr("action"),
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        // beforeSend: function () {
        //   $("#ajax-loader").show();
        // },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.status === 400) {
            $.each(data.error, function (i, val) {
              $("input[name=" + i + "]").after(
                '<div class="text-danger has_error">' + val + "</div>"
              );
              if ($("textarea[name=" + i + "]").length) {
                $("textarea[name=" + i + "]").after(
                  '<div class="text-danger has_error">' + val + "</div>"
                );
              }
              if ($("select[name=" + i + "]").length) {
                $("select[name=" + i + "]").after(
                  '<div class="text-danger has_error">' + val + "</div>"
                );
              }
            });
          } else if (data.status === 500) {
            swal("Sorry!", data.msg, "error");
          } else {
            //play();
            swal("Great!", data.msg, "success").then(function () {
              if (data.redirect == true) {
                window.location.href = data.url;
              } else {
                location.reload();
              }
              // $("#form-button").prop('disabled', true);
              // $('.modal').modal('hide');
            });
          }
          //$("#ajax-loader").hide();
        },
      }).fail(function (response, status, error) {
        var data = response.responseJSON;
        if (status === "error") {
          $.each(data.errors, function (i, val) {
            $("input[name=" + i + "]").after(
              '<div class="text-danger has_error">' + val + "</div>"
            );
            if ($("textarea[name=" + i + "]").length) {
              $("textarea[name=" + i + "]").after(
                '<div class="text-danger has_error">' + val + "</div>"
              );
            }
            if ($("select[name=" + i + "]").length) {
              $("select[name=" + i + "]").after(
                '<div class="text-danger has_error">' + val + "</div>"
              );
            }
          });
        }
      });
    }
  });

  //Append Selected text to input
  if ($(".append_selected_text").length) {
    $(".append_selected_text").change(function () {
      var text = $(this).find("option:selected").text();
      $(this).parent("div").find("input").val(text);
    });
  }
  // View Record
  $(document).on("click", ".viewRecord", function (e) {
    $(".has_error").hide();
    var url = $(this).data("url");
    var title = $(this).data("title");
    var row = $(this).parent();
    $.ajax({
      type: "get",
      url: url,
      success: function (response) {
        $(".modal-content").html(response);
      },
    });
  });

  // Edit Record
  $(document).on("click", ".editRecord", function (e) {
    var url = $(this).data("url");
    var updateAction = $(this).data("action");
    var title = $(this).data("title");
    var row = $(this).parent();
    $.ajax({
      type: "get",
      url: url,
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status === 200) {
          $("#modal" + title).modal("show");
          $("#modal" + title)
            .find("form")
            .attr("action", updateAction);
          $("#modal" + title)
            .find("form")
            .append('<input name="_method" type="hidden" value="PUT">');
          $(".modal-title").text("Edit " + title);
          $("#form-button").text("Update");
          $.each(data.result, function (i, val) {
            if (
              i != "image" &&
              i != "image1" &&
              i != "image2" &&
              i != "image3" &&
              i != "image4" &&
              i != "image5" &&
              i != "image6" &&
              i != "file"
            ) {
              $("input[name=" + i + "]").val(val);
            }
            if ($("textarea[name=" + i + "]").length) {
              $("textarea[name=" + i + "]").val(val);
            }
            if (i == "role_id") {
              $("select[name=role]").val(val);
            } else {
              if (i == "discount_type") {
                var d_type = 1;
                if (val == "value") {
                  d_type = 2;
                }
                $("select[name=" + i + "]").val(d_type);
              } else {
                $("select[name=" + i + "]").val(val);
              }
            }
            if (i == "state_id") {
              setTimeout(function () {
                getAjaxDataPlace(val, $(".editRecord").data("place_list"));
              }, 500);
            }
            if (i == "place_id") {
              setTimeout(function () {
                $("select[name=" + i + "]").val(val);
              }, 1000);
            }

            if (
              i == "image" ||
              i == "image1" ||
              i == "image2" ||
              i == "image3" ||
              i == "image4" ||
              i == "image5" ||
              i == "image6"
            ) {
              if (val != null) {
                $("input[name=" + i + "]").prop("required", false);
                $("input[name=" + i + "]").after(
                  '<div class="text-center mt-2"><img src="' +
                    val +
                    '" alt="Image" width="100px"> <a href="' +
                    val +
                    '" download title="Download" class="text-primary"><img src="" alt="Download"></a></div>'
                );
              }
              $("input[name=" + i + "]").after(
                '<input name="old_image" value="' + val + '" type="hidden">'
              );
            } else if (i == "file") {
              if ($(".uploaded-file").length) {
                $(".uploaded-file").html("");
              }
              if (val != "") {
                $("input[name=" + i + "]").after(
                  '<a href="' +
                    val +
                    '" taget="_blank" class="uploaded-file"><i class="fa fa-file-pdf-o"></i></a>'
                );
              }
              $("input[name=" + i + "]").after(
                '<input name="old_file" value="' + val + '" type="hidden">'
              );
            }
          });
        } else {
          swal("Sorry!", data.msg, "error");
        }
      },
    });
  });
  //Delete Record
  $(document).on("click", ".deleteRecord", function (e) {
    var url = $(this).data("url");
    var row = $(this).parent();
    swal("Are you sure", "want to delete?", "warning", {
      dangerMode: true,
      buttons: true,
    }).then(function (isConfirm) {
      if (isConfirm) {
        $.ajax({
          type: "POST",
          url: url,
          data: {
            _method: "DELETE",
            _token: $("meta[name='csrf-token']").attr("content"),
          },
          success: function (response) {
            var data = JSON.parse(response);
            if (data.status === 200) {
              //playAbeYaar();
              // swal("Success", data.msg, "success").then(function () {
              showSuccess(data.msg);
              row.slideUp(300, function () {
                row.closest("tr").remove();
                $("table#table_list tbody tr").each(function (index) {
                  $(this)
                    .children("td")
                    .first()
                    .text(index + 1);
                });
              });
              // });
            } else {
              showError(data.msg);
              // swal("Sorry!", data.msg, "error");
            }
          },
        });
      }
    });
  });
  //Remove Image
  $(document).on("click", ".removeImage", function (e) {
    var url = $(this).data("url");
    var src = $(this).data("src");
    var row = $(this).parent();
    swal("Are you sure", "want to delete?", "warning", {
      dangerMode: true,
      buttons: true,
    }).then(function (isConfirm) {
      if (isConfirm) {
        $.ajax({
          type: "GET",
          url: url,
          data: {
            _token: $("meta[name='csrf-token']").attr("content"),
            src: src,
          },
          success: function (response) {
            var data = JSON.parse(response);
            if (data.status === 200) {
              //
              swal("Success", data.msg, "success").then(function () {
                row.closest("div").remove();
              });
            } else {
              swal("Sorry!", data.msg, "error");
            }
          },
        });
      }
    });
  });
  //Change  Record satus
  $(document).on("click", ".updateStatus", function (e) {
    var url = $(this).data("url");
    swal("Are you sure", "want to change status?", "warning", {
      dangerMode: true,
      buttons: true,
    }).then(function (isConfirm) {
      if (isConfirm) {
        $.ajax({
          type: "get",
          url: url,
          success: function (response) {
            var data = JSON.parse(response);
            if (data.status === 200) {
              //play();
              showSuccess(data.msg);
              // swal("Success", data.msg, "success").then(function () {
              location.reload();
              // });
            } else {
              showError(data.msg);
              // swal("Sorry!", data.msg, "error");
            }
          },
        });
      }
    });
  });
  //Convert kyc client to non-kyc client
  $(document).on("click", ".updateKycStatus", function (e) {
    var url = $(this).data("url");
    swal("Are you sure", "want to convert?", "warning", {
      dangerMode: true,
      buttons: true,
    }).then(function (isConfirm) {
      if (isConfirm) {
        $.ajax({
          type: "get",
          url: url,
          success: function (response) {
            var data = JSON.parse(response);
            if (data.status === 200) {
              //play();
              swal("Success", data.msg, "success").then(function () {
                location.reload();
              });
            } else {
              swal("Sorry!", data.msg, "error");
            }
          },
        });
      }
    });
  });

  tinymce.init({
    selector: "#description",
    plugins:
      "a11ychecker advcode casechange export formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker",
    toolbar:
      "a11ycheck addcomment showcomments casechange checklist code export formatpainter pageembed permanentpen table",
    toolbar_mode: "floating",
    tinycomments_mode: "embedded",
    tinycomments_author: "Author name",
  });
  $('input[name="from"]').daterangepicker();

  $('input[name="date_concert"]').multiDatesPicker();

  // $(function () {
  //   var dateFormat = "mm/dd/yy",
  //     from = $("#from")
  //       .datepicker({
  //         defaultDate: "+1w",
  //         changeMonth: true,
  //         numberOfMonths: 3,
  //       })
  //       .on("change", function () {
  //         to.datepicker("option", "minDate", getDate(this));
  //       }),
  //     to = $("#to")
  //       .datepicker({
  //         defaultDate: "+1w",
  //         changeMonth: true,
  //         numberOfMonths: 3,
  //       })
  //       .on("change", function () {
  //         from.datepicker("option", "maxDate", getDate(this));
  //       });

  //   function getDate(element) {
  //     var date;
  //     try {
  //       date = $.datepicker.parseDate(dateFormat, element.value);
  //     } catch (error) {
  //       date = null;
  //     }

  //     return date;
  //   }
  // });

  //Inline form submit
});

function getCategoryData(type, url) {
  $.ajax({
    type: "get",
    url: url,
    data: {
      type: type,
    },
    success: function (response) {
      var data = JSON.parse(response);
      var list = "";
      if (data.length > 0) {
        list += '<option value="">Select</option>';
        $.each(data, function (k, v) {
          list += '<option value="' + v.id + '">' + v.category + "</option>";
        });
      } else {
        list += '<option value="">No Category Found!</option>';
      }
      $("#category").html(list);
    },
  });
}

function getAjaxData(id, url) {
  $.ajax({
    type: "get",
    url: url,
    data: {
      id: id,
    },
    success: function (response) {
      var data = JSON.parse(response);
      var list = "";
      if (data.length > 0) {
        list += '<option value="">Select</option>';
        $.each(data, function (k, v) {
          list += '<option value="' + v.id + '">' + v.category + "</option>";
        });
      } else {
        list += '<option value="">No Category Found!</option>';
      }
      $("#append_list").html(list);
    },
  });
}
//Get City List
function getAjaxDataCity(id, url) {
  $.ajax({
    type: "get",
    url: url,
    data: {
      id: id,
    },
    success: function (response) {
      var data = JSON.parse(response);
      var list = "";
      if (data.length > 0) {
        list += '<option value="">Select</option>';
        $.each(data, function (k, v) {
          list += '<option value="' + v.id + '">' + v.name + "</option>";
        });
      } else {
        list += '<option value="">No City Found!</option>';
      }
      $("#append_list").html(list);
    },
  });
}

//Get Place List
function getAjaxDataPlace(id, url) {
  $.ajax({
    type: "get",
    url: url,
    data: {
      id: id,
    },
    success: function (response) {
      var data = JSON.parse(response);
      var list = "";
      if (data.length > 0) {
        list += '<option value="">Select</option>';
        $.each(data, function (k, v) {
          list += '<option value="' + v.id + '">' + v.name + "</option>";
        });
      } else {
        list += '<option value="">No Place Found!</option>';
      }
      $("#place_id").html(list);
    },
  });
}
//Play alert sound
function play() {
  var audio = document.getElementById("audio");
  audio.play();
}

function playAbeYaar() {
  var audio = document.getElementById("abe-yaar");
  audio.play();
}

//Logout function
function logout() {
  swal("Are you sure", "want to logout?", "warning", {
    dangerMode: true,
    buttons: true,
  }).then(function (isConfirm) {
    if (isConfirm) {
      $(".logout-form").submit();
    }
  });
}

function showSuccess(msg) {
  toastr.success(msg);
}
function showInfo(msg) {
  toastr.info(msg);
}
function showError(msg) {
  toastr.error(msg);
}
function showWarning(msg) {
  toastr.warning(msg);
}

/**
 * @license
 * Copyright 2021 Google LLC.
 * SPDX-License-Identifier: Apache-2.0
 */
// The following example creates five accessible and
// focusable markers.
function initMap() {
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 12,
    center: { lat: 51.54879, lng: -9.2637 },
  });
  // Set LatLng and title text for the markers. The first marker (Boynton Pass)
  // receives the initial focus when tab is pressed. Use arrow keys to
  // move between markers; press tab again to cycle through the map controls.
  const tourStops = [
    [{ lat: 51.54879, lng: -9.26374 }, "Boynton Pass"],
    [{ lat: 51.53879, lng: -9.25374 }, "Airport Mesa"],
    [{ lat: 51.52879, lng: -9.24374 }, "Chapel of the Holy Cross"],
    [{ lat: 51.51879, lng: -9.23374 }, "Red Rock Crossing"],
    [{ lat: 51.50879, lng: -9.22374 }, "Bell Rock"],
  ];
  const tourStopss = [{ lat: 51.54879, lng: -9.26374 }];
  const flightPath = new google.maps.Polyline({
    path: tourStopss,
    geodesic: true,
    strokeColor: "#FF0000",
    strokeOpacity: 1.0,
    strokeWeight: 2,
  });

  flightPath.setMap(map);
  // Create an info window to share between markers.
  const infoWindow = new google.maps.InfoWindow();

  // Create the markers.
  const image = "https://gcdnb.pbrd.co/images/EsjrYbyrkSq7.png?o=1";

  tourStops.forEach(([position, title], i) => {
    const marker = new google.maps.Marker({
      position,
      map,
      icon: image,
      title: `${i + 1}. ${title}`,
      label: {
        text: `${i + 1}`, // codepoint from https://fonts.google.com/icons
        fontFamily: "Material Icons",
        color: "#0d0c0a",
        fontSize: "0px",
      },
      optimized: false,
    });

    // Add a click listener for each marker, and set up the info window.
    marker.addListener("click", () => {
      infoWindow.close();
      infoWindow.setContent(marker.getTitle());
      infoWindow.open(marker.getMap(), marker);
    });
  });
}

window.initMap = initMap;
