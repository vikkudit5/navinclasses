@extends('admin.layout')

@section('content')



    <!-- begin::main content -->

    <main class="main-content">

        <div class="container">

            <!-- begin::page header -->
            <div class="page-header">
                <h3>Upload Video</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{asset('dashboard')}}">Dashboard</a></li>

                        <li class="breadcrumb-item active" aria-current="page"><a href="{{asset('admin/video-list')}}">Video List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Upload Video</li>
                    </ol>
                </nav>
            </div>
            <!-- end::page header -->
            <div class="card">
                <div class="card-body">
                    <form id='file-catcher' enctype="multipart/form-data">
                        <input style="width: 200px; margin-right:5px;" multiple type="file" id="file-input"
                            name="file-input" class="form-control fileinput-button input-sm pull-left" />

                        <button type='submit' class="btn btn-info" id="do_submit" name="do_submit">
                            <i class="fa fa-cloud-upload"></i>&nbsp;Upload
                        </button>

                        <a href='{{asset('admin/video-list')}}' class="btn btn-primary pull-right">
                            <i class="fa fa-list"></i>&nbsp;Video List
                        </a>

                    </form>
                </div>
            </div>

            <span id="message-text" class="text-danger"></span>

            <div class="card">
                <div id="file-list-display" class="card-body">

                </div>
            </div>
        </div>

    </main>
    <!-- end::main content -->

@endsection
@push('footer-script')
    <!-- begin::dataTable -->
    <script>
        (function() {
            var fileCatcher = document.getElementById('file-catcher');
            var fileInput = document.getElementById('file-input');
            var fileListDisplay = document.getElementById('file-list-display');
            var textMessage = document.getElementById('message-text');
            var showDummyName = document.getElementById("showDummyName");

            var fileList = [];
            var renderFileList, sendFile;

            fileCatcher.addEventListener('submit', function(evnt) {
                evnt.preventDefault();

                if (fileList.length == 0) {
                    textMessage.innerHTML = "";
                    textMessage.innerHTML = "please select file!";
                    return false;
                }

                fileList.forEach(function(file) {

                    var str = "navinclassess/" + file.name;
                    dID = str.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');

                    var showOrigName = $('#' + dID).find('.showOrigName');
                    var showDummyName = $('#' + dID).find('.showDummyName');
                    var showTime = $('#' + dID).find('.showTime');


                    // if (showOrigName.val()) {
                    //     showOrigName.removeClass('is-invalid');
                    // } else {
                    //     showOrigName.addClass('is-invalid');
                    //     return false;
                    // }

                    // if (showDummyName.val()) {
                    //     showDummyName.removeClass('is-invalid');
                    // } else {
                    //     showDummyName.addClass('is-invalid');
                    //     return false;
                    // }

                    // if (showTime.val()) {
                    //     showTime.removeClass('is-invalid');
                    // } else {
                    //     showTime.addClass('is-invalid');
                    //     return false;
                    // }


                    // if (showOrigName.val() != '' && showDummyName.val() != '' && showTime.val() != '') {
                    // }
                    var uploadStatus = $('#' + dID).find('.uploadStatus').val('Uploading..');
                    sendFile(file);

                });
            });

            fileInput.addEventListener('change', function(evnt) {
                fileList = [];
                for (var i = 0; i < fileInput.files.length; i++) {
                    fileList.push(fileInput.files[i]);
                }
                renderFileList();

            });

            renderFileList = function() {
                fileListDisplay.innerHTML = '';

                fileList.forEach(function(file, index) {
                    // console.log(file);

                    var str = "navinclassess/" + file.name;
                    dID = str.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');

                    var rowDiv = document.createElement('div');
                    rowDiv.id = dID;
                    rowDiv.classList.add("row");

                    var colDiv = document.createElement('div');
                    colDiv.classList.add("col-md-2");

                    var colDiv1 = document.createElement('div');
                    colDiv1.classList.add("col-md-2");

                    var colDiv2 = document.createElement('div');
                    colDiv2.classList.add("col-md-2");

                    var colDiv3 = document.createElement('div');
                    colDiv3.classList.add("col-md-1");

                    var colDiv4 = document.createElement('div');
                    colDiv4.classList.add("col-md-2");

                    var colDiv5 = document.createElement('div');
                    colDiv5.classList.add("col-md-3");

                    //  Private Name
                    var inputTag = document.createElement('input');
                    inputTag.type = "text";
                    inputTag.value = file.name;
                    inputTag.placeholder = "Orignal Name";
                    inputTag.classList.add("form-control");
                    inputTag.classList.add("showOrigName");

                    // Public Name
                    var inputTagShow = document.createElement('input');
                    inputTagShow.type = "text";
                    inputTagShow.placeholder = "Public Name";
                    inputTagShow.classList.add("form-control");
                    inputTagShow.classList.add("showDummyName");

                    // Duration
                    var inputTagTime = document.createElement('input');
                    inputTagTime.type = "time";
                    inputTagTime.value = "";
                    inputTagTime.classList.add("form-control");
                    inputTagTime.classList.add("showTime");
                    inputTagTime.classList.add("clockpicker-autoclose-demo");

                    // Upload Status
                    var inputUploadStatus = document.createElement('label');
                    inputUploadStatus.type = "text";
                    inputUploadStatus.innerText = "Pending..";
                    inputUploadStatus.classList.add("form-control");
                    inputUploadStatus.classList.add("uploadStatus");

                    // Attechment
                    var btnTag = document.createElement('button');
                    btnTag.classList.add("btn");
                    btnTag.classList.add("btn-primary");
                    var iTag = document.createElement('i');
                    iTag.classList.add("fa");
                    iTag.classList.add("fa-paperclip");
                    iTag.classList.add("fa-lg");
                    btnTag.appendChild(iTag);

                    // ProgressBar
                    var progressBarDiv = document.createElement('div');
                    progressBarDiv.classList.add("progress");
                    progressBarDiv.style.marginTop = "35px";

                    var progressBar = document.createElement('progressbar');
                    progressBar.type = "text";
                    progressBar.setAttribute('aria-valuemin', '0');
                    progressBar.setAttribute('aria-valuemax', '100');
                    progressBar.setAttribute('aria-valuenow', '0');
                    progressBar.role = "progressbar";
                    progressBar.value = "";
                    progressBar.classList.add("progress-bar");
                    progressBar.classList.add("progress-bar-striped");
                    progressBar.classList.add("bg-warning");

                    progressBar.innerText = "0%";

                    // HR Tag
                    var hrTag = document.createElement('hr');


                    var labelTag1 = document.createElement('label');
                    labelTag1.innerText = "File Name";

                    var labelTag2 = document.createElement('label');
                    labelTag2.innerText = "Public Name";

                    var labelTag3 = document.createElement('label');
                    labelTag3.innerText = "Duration";

                    var labelTag4 = document.createElement('label');
                    labelTag4.innerText = "Status";

                    var labelTag5 = document.createElement('label');
                    labelTag5.innerText = "Attechment";


                    colDiv.appendChild(labelTag1);
                    colDiv.appendChild(inputTag);

                    colDiv1.appendChild(labelTag2);
                    colDiv1.appendChild(inputTagShow);

                    colDiv2.appendChild(labelTag3);
                    colDiv2.appendChild(inputTagTime);

                    colDiv3.appendChild(labelTag4);
                    colDiv3.appendChild(btnTag);

                    colDiv4.appendChild(labelTag5);
                    colDiv4.appendChild(inputUploadStatus);

                    progressBarDiv.appendChild(progressBar);
                    colDiv5.appendChild(progressBarDiv);


                    // rowDiv.appendChild(colDiv);
                    // rowDiv.appendChild(colDiv1);
                    // rowDiv.appendChild(colDiv2);
                    // rowDiv.appendChild(colDiv3);
                    // rowDiv.appendChild(colDiv4);
                    rowDiv.appendChild(colDiv5);
                    fileListDisplay.append(rowDiv);
                    fileListDisplay.append(hrTag);

                });
            };


            // upload file
            sendFile = function(file) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var url = "{{ asset('admin/aws_temp_url') }}";
                var formData = new FormData();
                formData.set('file', file);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(json) {
                        var arr = $.parseJSON(json);
                        if (arr['status'] == true) {
                            ajaxUploadFile(arr, file);
                            return false;
                        }
                        return false;
                    }
                });
            };

            bytesToSize = function(bytes) {
                var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                if (bytes == 0) return '0 Byte';
                var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
            }


            ajaxUploadFile = function(arr, _file) {
                var file = _file;
                var formAttributes = arr['formAttributes'];
                var formInputs = arr['formInputs'];
                var post_url = formAttributes['action'];
                var formData = new FormData();
                var str = "navinclassess/" + file.name;
                formInputs['key'] = str;
                Object.keys(formInputs).forEach(function(key) {
                    formData.append(key, formInputs[key]);
                });
                formData.append('x-amz-expires', '3600');
                formData.append('success_action_status', '201');

                if (file.type == "") {
                    formData.append('Content-Type', 'application/octet-stream');
                } else {
                    formData.append('Content-Type', file.type);
                }
                formData.append('file', file);

                var dID = str.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
                var dtTag = $('#' + dID).find('.progress-bar');
                $.ajax({
                    url: post_url,
                    type: 'POST',
                    datatype: 'xml',
                    data: formData,
                    contentType: false,
                    processData: false,
                    xhr: function() {
                        var xhr = $.ajaxSettings.xhr();
                        if (xhr.upload) {
                            var progressbar = $('#' + dID).find('.progress-bar');
                            var progressnumber = $('#' + dID).find('.progress-number');
                            $('#do_submit').attr('disabled', 'disabled');
                            $('#file-input').attr('disabled', 'disabled');
                            xhr.upload.addEventListener('progress', function(event) {
                                var progressbar = $('#' + dID).find('.progress-bar');
                                var progressnumber = $('#' + dID).find('.progress-number');
                                var percent = 0;
                                var position = event.loaded || event.position;
                                var total = event.total;
                                if (event.lengthComputable) {
                                    percent = Math.ceil(position / total * 100);
                                    progressbar.css("width", +percent + "%");
                                    progressbar.text(percent + " %");
                                    progressnumber.html("<b>" + Math.round(position / (1024)) +
                                        " KB<b/> / " + Math.round(total / (1024)) + " KB");
                                }
                            }, true);
                        }
                        return xhr;
                    }
                }).done(function(response) {
                    var url = $(response).find("Location").text();
                    var the_file_name = $(response).find("Key").text();
                    // Add in DB Lecture Entry
                    $("#" + dID).find(".uploadStatus").val('Uploaded..');

                }).fail(function(err) {
                    console.log(err);
                    if (err.responseText) {
                        var errorXML = $.parseXML(err.responseText);
                        var progressbar = $('#' + dID).find('.progress-bar');
                        var msgXML = $(errorXML).find('Message').text();
                        progressbar.html("<span class='text-danger'>" + msgXML + "</span>");
                    }
                });
            };
        })();
    </script>

    <script>
        // var limit = 5;
        // $(document).ready(function(){
        //     $('#image').change(function(){
        //         var file = $(this)[0].files;


        //         for(var i=0;i<file.length;i++)
        //         {
        //             console.log(file[i].name);
        //             var html = `<form><div class="row">

    //             <div class="col-md-2">
    //                 <input type="text" value=`+file[i].name+` class="form-control">
    //             </div>
    //             <div class="col-md-2">
    //                 <input type="text" class="form-control">
    //             </div>
    //             <div class="col-md-2">
    //                 <input type="text" class="form-control">
    //             </div>
    //             <div class="col-md-1">
    //                 <i class="fa fa-plus"></i>
    //             </div>

    //             <div class="col-md-2">
    //                 <input type="text" class="form-control">
    //             </div>

    //             <div class="col-md-2">
    //                 <progress id="file" value="32" max="100"> 32% </progress>
    //             </div>


    //         </div></div>`;

        //             $('.card-body').append(html);
        //         }
        //     });
        // });
    </script>

@endpush
