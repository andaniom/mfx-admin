<label for="photoInput">{{$label}}</label>
<div class="input-group mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text">Upload</span>
    </div>
    <div class="custom-file">
        <input name="files[]" type="file" class="custom-file-input" id="photoInput"
               accept="image/*" required {{ $multiple ? 'multiple' : ''}}>
        <label class="custom-file-label" for="photoInput">Choose file</label>
    </div>
</div>
<div id="divImageMediaPreview" ></div>
<div id="myModal" class="modal modal-img">
    <span class="close-modal">&times;</span>
    <img class="modal-content" id="img01" alt="">
    <div id="caption"></div>
</div>

