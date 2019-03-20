<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="card">
    <div class="card-header">
        Shipping
    </div>
    <div class="card-body">
        <div class="alert alert-success d-none" role="alert" id="dataAlert"></div>
        <table class="table table-bordered table-hover" id="dataTable">
            <thead>
                <tr>
                    <th scope="col">Shipping</th>
                    <th scope="col">Description</th>
                    <th scope="col">Image File</th>
                    <th scope="col" width="200">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-success" onclick="add();"><i class="fas fa-plus"></i> Add Shipping</button>
    </div>
</div>

<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none" role="alert" id="formAlert">
                    <ul class="m-0"></ul>
                </div>
                <form method="post">
                    <input type="hidden" id="ship_id" name="ship_id" value="">
                    <input type="hidden" id="ship_image" name="ship_image" value="">
                    <div class="form-group">
                        <label for="ship_name">Shipping</label>
                        <input type="text" class="form-control" id="ship_name" name="ship_name" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="ship_description">Description</label>
                        <input type="text" class="form-control" id="ship_description" name="ship_description" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="image_file">Image File</label>
                        <input type="file" class="form-control" id="image_file" name="image_file">
                        <div class="mt-3">
                            <img id="image_preview" style="max-width: 200px;">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                <button type="button" class="btn btn-primary" onclick="save();"><i class="fas fa-check"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        show();

        $("#image_file").change(function () {
            $("#image_preview").attr("src", URL.createObjectURL(this.files[0]));
        });
    });

    function show() {
        $.post("pages/shipping-service.php", function (result) {
            var row = "";

            $.each(result.data, function (index, value) {
                row += '<tr> \
                    <td>' + value.ship_name + '</td> \
                    <td>' + value.ship_description + '</td> \
                    <td>' + (value.ship_image != '' ? '<img src="' + value.ship_image + '" width="100">' : '') + '</td> \
                    <td> \
                        <button type="button" class="btn btn-primary btn-sm mr-1" onclick="edit(' + value.ship_id + ');"><i class="fas fa-pen"></i> Edit</button> \
                        <button type="button" class="btn btn-danger btn-sm" onclick="drop(' + value.ship_id + ');"><i class="fas fa-trash"></i> Delete</button> \
                    </td> \
                </tr>';
            });

            $("#dataTable tbody").empty().append(row);
        }, "json");
    }

    function add() {
        $("#ship_id").val("");
        $("#ship_name").val("");
        $("#ship_description").val("");
        $("#ship_image").val("");
        $("#image_file").val(null);
        $("#image_preview").attr("src", "");

        $("#formAlert").addClass("d-none");
        $("#formModalLabel").text("Add Shipping");
        $("#formModal").modal("show");
    }

    function edit(id) {
        if (typeof id !== "undefined") {
            $.post("pages/shipping-service.php", {ship_id: id}, function (result) {
                $("#ship_id").val(result.data.ship_id);
                $("#ship_name").val(result.data.ship_name);
                $("#ship_description").val(result.data.ship_description);
                $("#ship_image").val(result.data.ship_image);
                $("#image_file").val(null);
                $("#image_preview").attr("src", result.data.ship_image);

                $("#formAlert").addClass("d-none");
                $("#formModalLabel").text("Edit Shipping");
                $("#formModal").modal("show");
            }, "json");
        }
    }

    function save() {
        var data = new FormData($("form")[0]);
        data.append("action", ($("#ship_id").val() != "" ? "update" : "create"));

        $.ajax({
            url: "pages/shipping-service.php",
            data: data,
            dataType: "json",
            type: "POST",
            contentType: false,
            processData: false,
            success: function (result) {
                if (result.status == "success") {
                    $("#dataAlert").text(result.message);
                    $("#dataAlert").removeClass("d-none");

                    $("#formModal").modal("hide");

                    show();
                } else {
                    var list = "";

                    $.each(result.message, function (index, value) {
                        list += '<li>' + value + '</li>';
                    });

                    $("#formAlert ul").empty().append(list);
                    $("#formAlert").removeClass("d-none");
                }
            }
        });
    }

    function drop(id) {
        if (typeof id !== "undefined") {
            if (confirm("Are you sure to delete?") == true) {
                $.post("pages/shipping-service.php", {action: "delete", ship_id: id}, function (result) {
                    if (result.status == "success") {
                        $("#dataAlert").text(result.message);
                        $("#dataAlert").removeClass("d-none");

                        show();
                    }
                }, "json");
            }
        }
    }
</script>