function dropzoneHandler(urlUploadAllegato,urlDeleteAllegato,allegatiEsistenti,recordId,allegatoType,uid) {

    var myDropzone = new Dropzone("#kt_dropzonejs_example_1", {
        url: urlUploadAllegato, // Set the url for your upload script location
        paramName: "file", // The name that will be used to transfer the file
        maxFiles: 10,
        maxFilesize: 20, // MB
        addRemoveLinks: true,
        //acceptedFiles: "image/*",
        headers: {
            'X-CSRF-TOKEN':  $('meta[name="_token"]').attr('content')
        },
        init: function () {
            thisDropzone = this;
            this.on("sending", function (file, xhr, formData) {
                formData.append("uid", uid);
                formData.append("allegato_id", recordId);
                formData.append("allegato_type", allegatoType);

            });
            if (allegatiEsistenti) {
                $.each(allegatiEsistenti, function (key, value) {

                    var mockFile = {
                        name: value.path_filename,
                        size: value.dimensione_file,
                        filename: value.path_filename,
                        id: value.id
                    };

                    thisDropzone.emit('addedfile', mockFile);
                    if (value.thumbnail) {
                        thisDropzone.emit('thumbnail', mockFile, "/storage/" + value.thumbnail);

                    }
                    thisDropzone.emit('complete', mockFile);


                });
            }

        },
        accept: function (file, done) {
            if (file.name == "q") {
                done("Naha, you don't.");
            } else {
                done();
            }
        },
        success: function (file, response) {
            file.filename = response.filename;
            file.id = response.id;
            if (response.thumbnail) {
                file.previewElement.querySelector("img").src = response.thumbnail;
            }
        },
        removedfile: function (file) {
            console.dir(file);
            var name = file.filename;
            console.log(name);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                type: 'DELETE',
                url: urlDeleteAllegato,
                data: {
                    id: file.id
                },
                success: function (data) {
                    console.log("File has been successfully removed!!");
                },
                error: function (e) {
                    console.log(e);
                }
            });
            var fileRef;
            return (fileRef = file.previewElement) != null ?
                fileRef.parentNode.removeChild(file.previewElement) : void 0;
        },
    });


}
