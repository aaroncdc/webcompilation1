<div class="editor" ondrop="main_drop_handler(event);" ondragover="main_dragover_handler(event);" ondragend="main_dragend_handler(event);">
    <textarea id="userinput" class="userinput" placeholder="¿En qué piensas?"></textarea>
    <input type="hidden" name="sid" id="sid" value=<?php echo '"'.$current_session.'"';?>>
        <div class="editor-buttons">
            <i class="fa fa-smile-o" id="emoji-menu-button"></i>
            <div class="emoji-menu">
                <div class="emoji-list"></div>
                <div class="emoji-cats">
                <div class="emoji-cat-button" rel="0">
                    &#x1F388;
                </div>
                <div class="emoji-cat-button" rel="1">
                    &#x1F6A9;
                </div>
                <div class="emoji-cat-button" rel="2">
                    &#x1F34E;
                </div>
                <div class="emoji-cat-button" rel="3">
                    &#x1F337;
                </div>
                <div class="emoji-cat-button" rel="4">
                    &#x1F4BB;
                </div>
                <div class="emoji-cat-button" rel="5">
                    &#x1F600;
                </div>
                <div class="emoji-cat-button" rel="6">
                    &#x1F6BE;
                </div>
                <div class="emoji-cat-button" rel="7">
                    &#x1F30D;
                </div>
            </div>
        </div>
        <div class="file-uploader">
        </div>
    </div>
    
    <div class="editor-buttons-bottom">
        <i class="fa fa-camera"></i>
        <input type="file" id="upload-image-field" multiple>
    </div>
    <span class="text-counter" id="text-counter">0/500</span>
    <button class="post-message" id="post-message">Rawr!</button>
</div>