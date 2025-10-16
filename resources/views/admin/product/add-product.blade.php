@extends('admin_layout')
@section('content_dash')

    <?php use Illuminate\Support\Facades\Session; ?>

    <form action="{{URL::to('/submit-add-product')}}" method="POST" id="form-add-product" data-toggle="validator"
          enctype="multipart/form-data">
        @csrf
        <div class="content-page">
            <div class="container-fluid add-form-list">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Thêm sản phẩm</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="ProductName">Tên sản phẩm *</label>
                                            <input id="ProductName" name="ProductName" onkeyup="ChangeToSlug()"
                                                   type="text" class="form-control slug" placeholder="Vui lòng nhập tên"
                                                   data-errors="Please Enter Name." required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="ProductSlug" class="form-control" id="convert_slug">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="idCategory">Danh mục *</label>
                                            <select id="idCategory" name="idCategory" class="selectpicker form-control"
                                                    data-style="py-0" required>
                                                <option value="">Chọn danh mục sản phẩm</option>
                                                @foreach($list_category as $key => $category)
                                                    <option
                                                        value="{{$category->idCategory}}">{{$category->CategoryName}}</option>
                                                @endforeach
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="idBrand">Thương hiệu *</label>
                                            <select id="idBrand" name="idBrand" class="selectpicker form-control"
                                                    data-style="py-0" required>
                                                <option value="">Chọn thương hiệu sản phẩm</option>
                                                @foreach($list_brand as $key => $brand)
                                                    <option value="{{$brand->idBrand}}">{{$brand->BrandName}}</option>
                                                @endforeach
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="idBrand">Phân loại hàng</label>
                                            <button class="btn btn-outline-primary btn-sm"
                                                    type="button" onClick="addTableOption()">Thêm giá trị thuộc tính
                                            </button>
                                        </div>
                                        <div class="row" id="render_table_attr">

                                        </div>
                                    </div>
                                    <div class="col-md-12 d-flex flex-wrap input-attrs">
                                        <div class="col-md-12 d-flex flex-wrap attr-title">
                                            <div class="attr-title-1 col-md-6 text-center d-none"></div>
                                            <div class="attr-title-2 col-md-6 text-center d-none">Số lượng *</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Price">Giá *</label>
                                            <input id="Price" name="Price" type="number" min="0" class="form-control"
                                                   placeholder="Vui lòng nhập giá" data-errors="Please Enter Price."
                                                   required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Quantity">Tổng số lượng *</label>
                                            <input id="Quantity" name="QuantityTotal" type="number" min="0"
                                                   class="form-control" placeholder="Vui lòng nhập số lượng" disabled>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Hình ảnh *</label>
                                            <input name="ImageName[]" id="images" type="file"
                                                   onchange="loadPreview(this)" class="form-control  image-file"
                                                   multiple required/>
                                            <div class="help-block with-errors"></div>
                                            <div class="text-danger alert-img"></div>
                                            <div class="d-flex flex-wrap" id="image-list"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Mô tả ngắn *</label>
                                            <textarea id="ShortDes" name="ShortDes" class="form-control"
                                                      placeholder="Nhập mô tả ngắn" rows="3" required></textarea>
                                            <div class="text-danger alert-shortdespd"></div>
                                            <script>$(document).ready(function () {
                                                    CKEDITOR.replace('ShortDes');
                                                });</script>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Mô tả / Chi tiết sản phẩm *</label>
                                            <textarea id="DesProduct" name="DesProduct" class="form-control tinymce"
                                                      placeholder="Nhập mô tả chi tiết" rows="4"></textarea>
                                            <div class="text-danger alert-despd"></div>
                                            <script>$(document).ready(function () {
                                                    CKEDITOR.replace('DesProduct');
                                                });</script>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="data_options" value="" id="data_options">

                                <button type="submit" class="btn btn-primary mr-2" id="btn-submit"
                                        value="Thêm sản phẩm"> Thêm sản phẩm
                                </button>
                                <a href="{{URL::to('/manage-products')}}" class="btn btn-light">Trở về</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page end  -->

        <!-- Model phân loại hàng -->
        <div class="modal fade" id="modal-attributes" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="popup text-left">
                            <h4 class="mb-3">Thêm phân loại hàng</h4>
                            <div class="content create-workform bg-body">
                                <label class="mb-0">Nhóm phân loại</label>
                                <select name="idAttribute" id="attribute" class="selectpicker form-control choose-attr"
                                        data-style="py-0">
                                    <option value="">Chọn nhóm phân loại</option>
                                    @foreach($list_attribute as $key => $attribute)
                                        <option id="attr-group-{{$attribute->idAttribute}}"
                                                data-attr-group-name="{{$attribute->AttributeName}}"
                                                value="{{$attribute->idAttribute}}">{{$attribute->AttributeName}}</option>
                                    @endforeach
                                </select>

                                <div class="pb-3 d-flex flex-wrap" id="attribute_value">

                                </div>
                                <div class="col-lg-12 mt-4">
                                    <div class="d-flex flex-wrap align-items-ceter justify-content-center">
                                        <div class="btn btn-light mr-4" data-dismiss="modal">Trở về</div>
                                        <div class="btn btn-primary" id="confirm-attrs" data-dismiss="modal">Xác nhận
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        const attributes = {!! json_encode($list_attribute) !!};

        const htmlTableOption = `<table class="table table-bordered">
                        <colgroup>
                            <col width="x"/>
                            <col width="10%"/>
                            <col width="5%"/>
                        </colgroup>
                        <thead>
                        <tr>
                            <th class="align-middle">
                                <div class="d-flex align-items-center gap-4">
                                    <p>Thuộc tính</p>
                                    <button type="button" class="btn btn-outline-warning btn-sm"
                                            onclick="addProperty(this)">Thêm
                                    </button>
                                </div>
                            </th>
                            <th>Số lượng</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <div class="list_option">
                                    <div class="row attribute_property_item_">
                                        <div class="form-group col-md-5">
                                            <label for="attribute_item">Thuộc tính</label>
                                            <select name="attribute_item" class="form-control form_input_" onchange="getPropertyByAttribute(this)">
                                                <option value="">-- Chọn thuộc tính --</option>
                                                ${attributes.map((attribute) => `<option value="${attribute.idAttribute}">${attribute.AttributeName}</option>`).join('')}
                                            </select>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label for="property_item">Giá trị thuộc tính</label>
                                            <select name="property_item" class="form-control form_input_">
                                                <option value="">-- Chọn giá trị thuộc tính --</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mt-4">
                                            <button type="button" onclick="removePropertyItem(this)" class="btn btn-danger">Xoá</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input type="number" min="1" class="form-control form_input_" name="option_quantity"
                                       required/>
                            </td>
                            <td rowSpan="3" class="text-center align-middle">
                                <button class="btn btn-danger btn-sm" onclick="removeTableOption(this)"
                                        type="button">Xoá
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>`;

        $(document).ready(function () {
            $('#render_table_attr').append(htmlTableOption);
        })

        function addTableOption() {
            $('#render_table_attr').append(htmlTableOption);
        }

        function getPropertyByAttribute(el) {
            let attr = $(el).val();

            getListProperty(attr, el);
        }

        function generatePropertyItem(array_attr) {
            return `<div class="row attribute_property_item_">
                <div class="form-group col-md-5">
                    <label for="attribute_item">Thuộc tính</label>
                    <select name="attribute_item" class="form-control form_input_" onchange="getPropertyByAttribute(this)">
                        <option value="">-- Chọn thuộc tính --</option>
                        ${attributes.filter((attribute) => !array_attr.includes(attribute.idAttribute))
                .map((attribute) => `<option value="${attribute.idAttribute}">${attribute.AttributeName}</option>`)
                .join('')}
                    </select>
                </div>
                <div class="form-group col-md-5">
                    <label for="property_item">Giá trị thuộc tính</label>
                    <select name="property_item" class="form-control form_input_">
                        <option value="">-- Chọn giá trị thuộc tính --</option>
                    </select>
                </div>
                <div class="col-md-2 mt-4">
                    <button type="button" onclick="removePropertyItem(this)" class="btn btn-danger">Xoá</button>
                </div>
            </div>`;
        }

        function addProperty(el) {
            let array_attr = [];
            $(el).closest('table').find('.list_option .attribute_property_item_').each(function () {
                let attr = $(this).find('select[name="attribute_item"]').val();
                attr = parseInt(attr);
                array_attr.push(attr)
            })

            array_attr = array_attr.filter(onlyUnique);
            $(el).closest('table').find('.list_option').append(generatePropertyItem(array_attr));
        }

        function onlyUnique(value, index, array) {
            return array.indexOf(value) === index;
        }

        function removePropertyItem(el) {
            $(el).closest('.attribute_property_item_').remove();
        }

        function removeTableOption(el) {
            $(el).closest('table').remove();
        }

        async function getListProperty(attribute_id, el) {
            let url = '{{ route('api.attribute.values.list') }}?attribute_id=' + attribute_id;

            await $.ajax({
                url: url,
                type: 'GET',
                async: false,
                success: function (data, textStatus) {
                    renderProperty(el, data.data);
                },
                error: function (request, status, error) {
                    let data = JSON.parse(request.responseText);
                    alert(data.message);
                }
            });
        }

        function renderProperty(el, data) {
            let html = '';
            for (let i = 0; i < data.length; i++) {
                html += `<option value="${data[i].idAttrValue}">${data[i].AttrValName}</option>`;
            }
            $(el).parent().next().find('select[name="property_item"]').html(html);
        }
    </script>

    <script>
        $('#form-add-product').on('submit', function (e) {
            e.preventDefault();

            let _table_attr = $('#render_table_attr').find('tbody');

            let data_options = [];
            _table_attr.each(function () {
                let _this = $(this);
                let list_option = _this.find('.list_option');

                let item = [];
                list_option.find('.attribute_property_item_').each(function () {
                    let el = $(this);
                    let attribute_item = el.find('select[name="attribute_item"]').val();
                    let property_item = el.find('select[name="property_item"]').val();

                    let _child = {
                        attribute_item: attribute_item,
                        property_item: property_item
                    }
                    item.push(_child)
                })

                let option_quantity = _this.find('input[name="option_quantity"]').val();

                let _data = {
                    _options: item,
                    quantity: option_quantity,
                }
                data_options.push(_data)
            })

            $('#data_options').val(JSON.stringify(data_options));

            this.submit();
        });
    </script>
    <script>
        @if(Session::has('message'))
        Swal.fire({
            title: '{{ Session::get('message') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location = "{{ url('manage-products') }}";
        });
        @endif
    </script>
    <!-- Validate ảnh -->
    <script>
        function loadPreview(input) {
            $('.image-item').remove();
            var data = $(input)[0].files; //this file data
            $.each(data, function (index, file) {
                if (/(\.|\/)(gif|jpeg|png|jpg|svg)$/i.test(file.type) && file.size < 2000000) {
                    var fRead = new FileReader();
                    fRead.onload = (function (file) {
                        return function (e) {
                            var img = $('<img/>').addClass('img-fluid rounded avatar-100 mr-3 mt-2').attr('src', e.target.result); //create image thumb element
                            $("#image-list").append('<div id="image-item-' + index + '" class="image-item"></div>');
                            $('#image-item-' + index).append(img);
                            //    $('#image-item-'+index).append('<span id="dlt-item-'+index+'" class="dlt-item"><span class="dlt-icon">x</span></span>');
                        };
                    })(file);
                    fRead.readAsDataURL(file);
                    $('.alert-img').html("");
                    $('#btn-submit').removeClass('disabled-button');
                } else {
                    document.querySelector('#images').value = '';
                    $('.alert-img').html("Tệp hình ảnh phải có định dạng .gif, .jpeg, .png, .jpg, .svg dưới 2MB");
                    //    $('#btn-submit').addClass('disabled-button');
                }
            });
        }
    </script>

    <!-- Validate ckeditor -->
    <script>
        $(document).ready(function () {
            CKEDITOR.instances['DesProduct'].on('change', function () {
                var messageLength = CKEDITOR.instances['DesProduct'].getData().replace(/<[^>]*>/gi, '').length;
                if (!messageLength) {
                    $('.alert-despd').html("Vui lòng điền vào trường này.");
                    $('#btn-submit').addClass('disabled-button');

                } else {
                    $('.alert-despd').html("");
                    $('#btn-submit').removeClass('disabled-button');
                }
            });

            CKEDITOR.instances['ShortDes'].on('change', function () {
                var messageLength = CKEDITOR.instances['ShortDes'].getData().replace(/<[^>]*>/gi, '').length;
                if (!messageLength) {
                    $('.alert-shortdespd').html("Vui lòng điền vào trường này.");
                    $('#btn-submit').addClass('disabled-button');

                } else {
                    $('.alert-shortdespd').html("");
                    $('#btn-submit').removeClass('disabled-button');
                }
            });

            $("#form-add-product").submit(function (e) {
                var messageLength = CKEDITOR.instances['DesProduct'].getData().replace(/<[^>]*>/gi, '').length;
                var messageLength2 = CKEDITOR.instances['ShortDes'].getData().replace(/<[^>]*>/gi, '').length;

                if (!messageLength) {
                    $('.alert-despd').html("Vui lòng điền vào trường này.");
                    e.preventDefault();
                }
                if (!messageLength2) {
                    $('.alert-shortdespd').html("Vui lòng điền vào trường này.");
                    e.preventDefault();
                }
            });
        });
    </script>

    <!-- Validate phân loại hàng -->
    <script>
        $(document).ready(function () {
            $('.choose-attr').on('change', function () {
                var action = $(this).attr('id');
                var idAttribute = $(this).val();
                var attr_group_name = $("#attr-group-" + idAttribute).data("attr-group-name");
                var _token = $('input[name="_token"]').val();
                var result = '';

                if (action == 'attribute') result = 'attribute_value';
                $.ajax({
                    url: '{{url("/select-attribute")}}',
                    method: 'POST',
                    data: {action: action, idAttribute: idAttribute, _token: _token},
                    success: function (data) {
                        $('#' + result).html(data);

                        $("input[type=checkbox]").on("click", function () {
                            var attr_id = $(this).data("id");
                            var attr_name = $(this).data("name");

                            if ($(this).is(":checked")) {
                                $("#attr-name-" + attr_id).addClass("border-primary text-primary");

                                $("#confirm-attrs").click(function () {
                                    var input_attrs_item = '<div id="input-attrs-item-' + attr_id + '" class="col-md-12 d-flex flex-wrap input_attrs_items"><div class="col-md-6"><input class="form-control text-center" type="text" value="' + attr_name + '" disabled></div><div class="form-group col-md-6"><input id="qty-attr-' + attr_id + '" class="form-control text-center qty-attr" name="qty_attr[]" placeholder="Nhập số lượng phân loại" type="number" min="0" required></div></div>';
                                    if ($('#input-attrs-item-' + attr_id).length < 1) $('.input-attrs').append(input_attrs_item);

                                    $(".qty-attr").on("input", function () {
                                        var total_qty = 0;
                                        $(".qty-attr").each(function () {
                                            if (!isNaN(parseInt($(this).val()))) {
                                                total_qty += parseInt($(this).val());
                                            }
                                        });
                                        $("#Quantity").val(total_qty);
                                    });

                                    $("#qty-attr-" + attr_id).on("change", function () {
                                        if ($(this).val() == "" || $(this).val() < 0) {
                                            $(this).css("border", "1px solid #E08DB4");
                                            $('#btn-submit').addClass('disabled-button');
                                        } else {
                                            $(this).css("border", "1px solid #DCDFE8");
                                            $('#btn-submit').removeClass('disabled-button');
                                        }
                                    });

                                    $("#form-add-product").submit(function (e) {
                                        var val_input = $('#qty-attr-' + attr_id).val();
                                        if (val_input == "" || val_input < 0) {
                                            e.preventDefault();
                                            $('#qty-attr-' + attr_id).css("border", "1px solid #E08DB4");
                                        }
                                    });
                                });
                            } else if ($(this).is(":not(:checked)")) {
                                $("#attr-name-" + attr_id).removeClass("border-primary text-primary");

                                $("#confirm-attrs").click(function () {
                                    $('#input-attrs-item-' + attr_id).remove();

                                    // Số lượng input
                                    var total_qty = 0;
                                    $(".qty-attr").each(function () {
                                        if (!isNaN(parseInt($(this).val()))) {
                                            total_qty += parseInt($(this).val());
                                        }
                                    });
                                    $("#Quantity").val(total_qty);
                                });
                            }

                            $('.choose-attr').on('change', function () {
                                $('.chk_attr').prop('checked', false);

                                $("#confirm-attrs").click(function () {
                                    $('.input_attrs_items').remove();
                                });
                            });
                        });

                        $("#confirm-attrs").click(function () {
                            if ($('[name="chk_attr[]"]:checked').length >= 1) {
                                $('.attr-title-1').html(attr_group_name);
                                $('.attr-title-1').removeClass('d-none');
                                $('.attr-title-2').removeClass('d-none');
                                $('#Quantity').addClass('disabled-input');
                            } else {
                                $('.attr-title-1').addClass('d-none');
                                $('.attr-title-2').addClass('d-none');
                                $('#Quantity').removeClass('disabled-input');
                            }
                        });
                    }
                });
            });
        });
    </script>
<!-- tự động tính tổng số lượng thuộc tính sản phẩm -->
<script>
     window.addEventListener('click', function() {
        const list_input = $('input[name="option_quantity"]');

        let total_qty = 0;
        for (let i = 0; i < list_input.length; i++) {
            const input = list_input[i];

            const qty = $(input).val();

            total_qty += parseInt(qty);
        }

        $('#Quantity').val(total_qty);
    });
</script>
@endsection
