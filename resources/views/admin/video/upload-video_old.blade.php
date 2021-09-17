@extends('admin.layout')

@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Product</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  
                    <li class="breadcrumb-item active" aria-current="page">Product</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->
        
        <div class="row">
            {{-- <a href="{{asset('admin/add-product')}}" class="form-group btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp; Add Product</a> --}}
            {{-- <input type="file" class="form-control" id="image" multiple> --}}

            <form id='file-catcher' enctype="multipart/form-data">
                {{-- <input id='file-input' name="file" type='file' multiple  /> --}}

				<input style="width: 200px;" multiple type="file" id="file-input" name="file-input" class="form-control fileinput-button input-sm pull-left" />
                <!-- <input type="file" name="file[]" multiple id="fileUpload"> -->
                <button type='submit' class="btn btn-warning" id="do_submit" name="do_submit">
                   <i class="fa fa-cloud-upload"></i>  Submit
                </button>
            </form>

			
		</div>
		<span id="message-text" class="text-danger"></span>

        <div class="card">
           
            <div class="card-body">     
               
               
                <div id='file-list-display'></div>


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

					var showOrigName = $('#' + dID).find('.showOrigName').val();
					var showDummyName = $('#' + dID).find('.showDummyName').val();
					var showTime = $('#' + dID).find('.showTime').val();

					if(showOrigName == '')
					{
						textMessage.innerHTML = "";
						textMessage.innerHTML = "please Input Original Name!";
						return false;
					}

					if(showDummyName == '')
					{
						textMessage.innerHTML = "";
						textMessage.innerHTML = "please Input Show Name!";
						return false;
					}

					if(showTime == '')
					{
						textMessage.innerHTML = "";
						textMessage.innerHTML = "please select Time!";
						return false;
					}

					if(showOrigName != '' && showDummyName != '' && showTime != '')
					{
						var uploadStatus = $('#' + dID).find('.uploadStatus').val('proccessing');

						
						sendFile(file);
					}
					
				});
			});

			fileInput.addEventListener('change', function(evnt) {
                // console.log(showDummyName);
				// return false;
				//fileList = [];
				for (var i = 0; i < fileInput.files.length; i++) {
					fileList.push(fileInput.files[i]);
				}
				renderFileList();
			});

			renderFileList = function() {
				fileListDisplay.innerHTML = '';
				
				fileList.forEach(function(file, index) {
					// console.log(file);

					// var dID = str.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');

					var str = "navinclassess/" + file.name;
					dID = str.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');

					var html = `  <div class="row" id=`+dID+`>               
					            <div class="col-md-2">
					                <input type="text" value=`+file.name+` id="showOrigName" placeholder="name" class="form-control showOrigName">
					            </div>
					            <div class="col-md-2">
					                <input type="text" placeholder="show name" class="form-control showDummyName">
					            </div>
					            <div class="col-md-2">
					                <input type="time" class="form-control showTime">
					            </div>
					            <div class="col-md-1">
					                <i class="fa fa-paperclip" style="font-size:32px;" aria-hidden="true"></i>
					            </div>
			
					            <div class="col-md-2">
					                <input type="text" readnoly value="pending" class="form-control uploadStatus">
					            </div>
			
					            <div class="col-md-2">
					                <progress class="progress-bar" value="0" max="100"> `+bytesToSize(file.size)+` </progress>
									<span class="progress-number"></span>
					            </div></div>`;

				

					fileListDisplay.innerHTML += html;
                    
				});
			};


			// upload file
			sendFile = function(file) {

				$.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                });

            var url = "{{asset('admin/aws_temp_url')}}";
            var formData = new FormData();
            formData.set('file', file);
            // formData.set('type', file);
            // console.log(file);
            // return false;
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(json) {
                    var arr = $.parseJSON(json);
                    // console.log(arr['status']);
                    // return false;
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

			// console.log(_file);
			// return false;
            var file = _file;
            // var filetype = _file['type'];

            var formAttributes = arr['formAttributes'];
            var formInputs = arr['formInputs'];
            var post_url = formAttributes['action'];
            var formData = new FormData();

            var str = "navinclassess/" + file.name;
            // if (filetype == 'pdf') {
            //     str = "pdffile/" + file.name;
            // }
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
                                progressnumber.html("<b>" + Math.round(position / (1024)) + " KB<b/> / " + Math.round(total / (1024)) + " KB");
                            }
                        }, true);
                    }
                    return xhr;
                }
            }).done(function(response) {				
				
                var url = $(response).find("Location").text();
                var the_file_name = $(response).find("Key").text();
				$("#" + dID).find(".uploadStatus").val('completed');
                // $("#" + dID).find(".uploadStatus").append("<span>File has been uploaded, Here's your file <a href=https://" + url + ">" + the_file_name + "</a></span>");
            }).error(function(err) {
				// console.log(err);
				// return false;

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
      
        </script>

@endpush