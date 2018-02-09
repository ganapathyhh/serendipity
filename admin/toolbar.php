<div class = "toolbar" unselectable = "on">
            <div class="tiny reveal" id="ImageModal" data-reveal>
                <ul class="tabs" data-tabs id="imageModal-tabs">
                  <li class="tabs-title is-active"><a href="#panel1" aria-selected="true">Insert From Internet</a></li>
                  <li class="tabs-title"><a data-tabs-target="panel2" href="#panel2">Upload From Computer</a></li>
                </ul>
                <div class="tabs-content" data-tabs-content="imageModal-tabs">
                      <div class="tabs-panel is-active" id="panel1">
                        <form class = "insertWeb">
                            <label>URL
                                <input type="text" placeholder="Image URL" value = "http://" autocomplete = "off">
                            </label>
                            <label>Description
                                <input type="text" placeholder="Image Description" autocomplete = "off">
                            </label>
                            
                            <label>Dimensions
                                <div class  = "grid-x grid-padding-x ">
                                    <div class = "small-6 cell">
                                        <input type="text" placeholder="Image Width(in px)" autocomplete = "off">  
                                    </div>
                                    <div class = "small-6 cell">
                                        <input type="text" placeholder="Image Height(in px)" autocomplete = "off">
                                    </div>
                                </div>
                            </label>
                        </form>
                          <a class = "button submitImageFromInternet">Submit</a>
                    </div>
                      <div class="tabs-panel" id="panel2" ondrop="drop(event)" ondragover="allowDrop(event)">
                          <form class = "imageUploadFromPc" >
                                <input type = "file" name = "imageFileUpload" id= "imageFileUpload" class = "button" style = "display:none" multiple>
                                <a class = "button" onclick="document.getElementById('imageFileUpload').click()">Upload</a>
                          </form>
                      </div>
                </div>
                  <button class="close-button" data-close aria-label="Close reveal" type="button">
                        <span aria-hidden="true">&times;</span>
                  </button>
            </div>
    <button id = "InsertItems" data-toggle="insertItems-Dropdown" aria-controls="insertItems-Dropdown" aria-expanded="false" title = "Text Color"><i class = "fa fa-plus  "></i>
            </button>
            <div class="dropdown-pane" data-dropdown data-hover="true" data-hover-pane = "true"  data-alignment='center' id="insertItems-Dropdown" >
                <ul class = "menu">
                        <li><a id = "insertImage" title = "Insert Image" data-toggle = "ImageModal"><i class = "fa fa-picture-o"></i> Image</a></li>
                        <li><a id = "insertTable" title = "Insert Table"><i class = "fa fa-table"></i> Table</a></li>
                        <li><a id = "insertLink" title = "Insert Link"><i class = "fa fa-link"></i> Link</a></li>
                        <li><a id = "insertMedia" title = "Insert Media"><i class = "fa fa-film"></i> Media</a></li>
                </ul>
            </div>
    <span class = "vl"></span>
            <button id = "boldButton" title = "Bold"><i class = "fa fa-bold"></i></button>
            <button id = "italicButton" title = "Italic"><i class = "fa fa-italic"></i></button>
            <button id = "underLineButton" title = "Underline"><i class = "fa fa-underline"></i></button>
            <button id = "strikeButton" title = "Strikethrough"><i class = "fa fa-strikethrough"></i></button>
            <button id = "subscriptButton" title = "Subscript"><i class = "fa fa-subscript"></i></button>
            <button id = "superscriptButton" title = "Superscript"><i class = "fa fa-superscript"></i></button>
    <span class = "vl"></span>
            <button id = "listOlButton" title = "Ordered List"><i class = "fa fa-list-ol  "></i></button>
            <button id = "listUlButton" title = "Unordered List"><i class = "fa fa-list-ul  "></i></button>
    <span class = "vl"></span>
            <button id = "leftAlignButton" title = "Left Align"><i class = "fa fa-align-left  "></i></button>
            <button id = "centerAlignButton" title = "Center Align"><i class = "fa fa-align-center  "></i></button>
            <button id = "rightAlignButton" title = "Right Align"><i class = "fa fa-align-right  "></i></button>
            <button id = "justifyAlignButton" title = "Justify"><i class = "fa fa-align-justify  "></i></button>
    <span class = "vl"></span>
            <button id = "undoButton" title = "Undo"><i class = "fa fa-undo  "></i></button>
            <button id = "redoButton" title = "Redo"><i class = "fa fa-repeat  "></i></button>
    <span class = "vl"></span>
            <button id = "indentButton" title = "Indent"><i class = "fa fa-indent  "></i></button>
            <button id = "dedentButton" title = "Unindent"><i class = "fa fa-dedent  "></i></button>
    <span class = "vl"></span>
            <button id = "paragraphButton" title = "Paragraph"><i class = "fa fa-paragraph  "></i></button>
            <button id = "unlinkButton" title = "Unlink"><i class = "fa fa-unlink  "></i></button>
            <button id = "horizontalLineButton" title = "Horizontal Line"><i class = "fa fa-minus"></i></button>
    <span class = "vl"></span>
            <select id = "headingSelect" title = "Heading" class = "dropdown-editor ">
                <option value = "<H1>">Heading 1</option>
                  <option value = "<H2>">Heading 2</option>
                  <option value = "<H3>">Heading 3</option>
                  <option value = "<H4>">Heading 4</option>
                  <option value = "<H5>">Heading 5</option>
                  <option value  = "<H6>">Heading 6</option>
            </select>   
            
             <select id = "fontSelect" title = "Fonts" class = "dropdown-editor">
                <option value = "Arial">Arial</option>
                <option value = "comic sans ms">Comic Sans Ms</option>
                <option value = "calibri">Calibri</option>
                 <option value = "consolas">Consolas</option>
                 <option value = "courier">Courier</option>
                 <option value = "cursive">Cursive</option>
                <option value = "Georgia">Georgia</option>
                 <option value = "Helvetica">Helvetica</option>
                 <option value = "monospace">Monospace</option>
                 <option value = "sans-serif">Sans-serif</option>
                <option value = "tahoma">Tahoma</option>
                <option value = "Times New Roman">Times New Roman</option>
                <option value = "verdana">Verdana</option>
             </select>
            <button id = "color-select" data-toggle="fore-color" aria-controls="fore-color" aria-expanded="false" title = "Text Color"><i class = "fa fa-tint  "></i>
            </button>
            <div class="dropdown-pane" id="fore-color" data-dropdown data-hover="true" data-alignment='center' data-hover-pane = "true" >
                <ul class="tabs" data-tabs id="imageModal-tabs">
                  <li class="tabs-title is-active"><a href="#color-palette-panel1" aria-selected="true">Text</a></li>
                  <li class="tabs-title"><a data-tabs-target="color-palette-panel2" href="#color-palette-panel2">Background</a></li>
                </ul>
                
                <ul class = "horizontal menu color-palette">
                    <li style = "background-color: #000000;"><a title = "Black" value = "Black"></a></li>
                    <li style = "background-color: #444444;"><a title = "Medium Black" value = "MediumBlack"></a></li>
                    <li style = "background-color: #666666;"><a title = "Light Black" value = "LightBlack"></a></li>
                    <li style = "background-color: #999999;"><a title = "Dim Black" value = "DimBlack"></a></li>
                    <li style = "background-color: #CCCCCC;"><a title = "Gray" value = "Gray"></a></li>
                    <li style = "background-color: #EEEEEE;"><a title = "Dim Gray" value = "DimGray"></a></li>
                    <li style = "background-color: #F3F3F3;"><a title = "Light Gray" value = "LightGray"></a></li>
                    <li style = "background-color: #FFFFFF;"><a title = "White" value = "White"></a></li>
                    <li style = "background-color: #FF0000;"><a title = "Red" value = "Red"></a></li>
                    <li style = "background-color: #FF9900;"><a title = "Orange" value = "Orange"></a></li>
                    <li style = "background-color: #FFFF00;"><a title = "Yellow" value = "Yellow"></a></li>
                    <li style = "background-color: #00FF00;"><a title = "Lime" value = "Lime"></a></li>
                    <li style = "background-color: #00FFFF;"><a title = "Cyan" value = "Cyan"></a></li>
                    <li style = "background-color: #0000FF;"><a title = "Blue" value = "Blue"></a></li>
                    <li style = "background-color: #8A2BE2;"><a title = "Blue Violet" value = "BlueViolet"></a></li>
                    <li style = "background-color: #FF00FF;"><a title = "Magenta" value = "Magenta"></a></li>
                    <li style = "background-color: #FFB6C1;"><a title = "Light Pink" value = "LightPink"></a></li>
                    <li style = "background-color: #FCE5CD;"><a title = "Bisque" value = "Bisque"></a></li>
                    <li style = "background-color: #FFF2CC;"><a title = "Blanched Almond" value = "BlanchedAlmond"></a></li>
                    <li style = "background-color: #D9EAD3;"><a title = "Light Lime" value = "LightLime"></a></li>
                    <li style = "background-color: #D0E0E3;"><a title = "Light Cyan" value = "LightCyan"></a></li>
                    <li style = "background-color: #CFE2F3;"><a title = "Alice Blue" value = "AliceBlue"></a></li>
                    <li style = "background-color: #D9D2E9;"><a title = "Lavendar" value = "Lavendar"></a></li>
                    <li style = "background-color: #EAD1DC;"><a title = "Thistle" value = "Thistle"></a></li>
                    <li style = "background-color: #EA9999;"><a title = "Light Coral" value = "LightCoral"></a></li>
                    <li style = "background-color: #F9CB9C;"><a title = "Wheat" value = "Wheat"></a></li>
                    <li style = "background-color: #FFE599;"><a title = "Navajo White" value = "NavajoWhite"></a></li>
                    <li style = "background-color: #B6D7A8;"><a title = "Dark Sea Green" value = "DarkSeaGreen"></a></li>
                    <li style = "background-color: #A2C4C9;"><a title = "Light Blue" value = "LightBlue"></a></li>
                    <li style = "background-color: #9FC5E8;"><a title = "Sky Blue" value = "SkyBlue"></a></li>
                    <li style = "background-color: #B4A7D6;"><a title = "Light Purple" value = "LightPurple"></a></li>
                    <li style = "background-color: #D5A6BD;"><a title = "Pale Violet Red" value = "PaleVioletRed"></a></li>
                    <li style = "background-color: #E06666;"><a title = "Indian Red" value = "IndianRed"></a></li>
                    <li style = "background-color: #F6B26B;"><a title = "Light Sandy Brown" value = "LightSandyBrown"></a></li>
                    <li style = "background-color: #FFD966;"><a title = "Khaki" value = "Khaki"></a></li>
                    <li style = "background-color: #93C47D;"><a title = "Yellow Green" value = "YellowGreen"></a></li>
                    <li style = "background-color: #76A5AF;"><a title = "Cadet Blue" value = "CadetBlue"></a></li>
                    <li style = "background-color: #6FA8DC;"><a title = "Deep Sky Blue" value = "DeepSkyBlue"></a></li>
                    <li style = "background-color: #8E7CC3;"><a title = "Medium Purple" value = "MediumPurple"></a></li>
                    <li style = "background-color: #C27BA0;"><a title = "Medium Violet Red" value = "MediumVioletRed"></a></li>
                    <li style = "background-color: #CC0000;"><a title = "Crimson" value = "Crimson"></a></li>
                    <li style = "background-color: #E69138;"><a title = "Sandy Brown" value = "SandyBrown"></a></li>
                    <li style = "background-color: #F1C232;"><a title = "Gold" value = "Gold"></a></li>
                    <li style = "background-color: #6AA84F;"><a title = "Medium Sea Green" value = "MediumSeaGreen"></a></li>
                    <li style = "background-color: #45818E;"><a title = "Teal" value = "Teal"></a></li>
                    <li style = "background-color: #3D85C6;"><a title = "Steel Blue" value = "SteelBlue"></a></li>
                    <li style = "background-color: #674EA7;"><a title = "Slate Blue" value = "SlateBlue"></a></li>
                    <li style = "background-color: #A64D79;"><a title = "Violet Red" value = "VioletRed"></a></li>
                    <li style = "background-color: #990000;"><a title = "Brown" value = "Brown"></a></li>
                    <li style = "background-color: #B45F06;"><a title = "Chocolate" value = "Chocolate"></a></li>
                    <li style = "background-color: #BF9000;"><a title = "Golden Rod" value = "GoldenRod"></a></li>
                    <li style = "background-color: #38761D;"><a title = "Green" value = "Green"></a></li>
                    <li style = "background-color: #134F5C;"><a title = "Slate Gray" value = "SlateGray"></a></li>
                    <li style = "background-color: #0B5394;"><a title = "Royal Blue" value = "RoyalBlue"></a></li>
                    <li style = "background-color: #351C75;"><a title = "Indigo" value = "Indigo"></a></li>
                    <li style = "background-color: #741B47;"><a title = "Maroon" value = "Maroon"></a></li>
                    <li style = "background-color: #660000;"><a title = "Dark Red" value = "DarkRed"></a></li>
                    <li style = "background-color: #783F04;"><a title = "Saddle Brown" value = "SaddleBrown"></a></li>
                    <li style = "background-color: #7F6000;"><a title = "Dark Golden Rod" value = "DarkGoldenRod"></a></li>
                    <li style = "background-color: #274E13;"><a title = "Dark Green" value = "DarkGreen"></a></li>
                    <li style = "background-color: #0C343D;"><a title = "Dark Slate Gray" value = "DarkSlateGray"></a></li>
                    <li style = "background-color: #073763;"><a title = "Navy" value = "Navy"></a></li>
                    <li style = "background-color: #20124D;"><a title = "Midnight Blue" value = "MidnightBlue"></a></li>
                    <li style = "background-color: #4C1130;"><a title = "Dark Maroon" value = "DarkMaroon"></a></li>
                    <li><input type = "text" name = "color-input-box" id = "color-input-box" placeholder = "Hex Value" style = "display: inline-block; width:75%"><a class = "button primary" style = "display: inline-block">OK</a></li>
                </ul>
            </div>
            <?php /*<button id = "back-color-select" data-toggle="fore-color" aria-controls="back-color" aria-expanded="false" title = "Highlight Color"><i class = "fa fa-paint-brush"></i></button>*/ ?>
    
    <span class = "vl"></span>
            
            <button id = "clearFormat" title = "Clear Format"><i class = "fa fa-eraser  "></i></button>
            <button id = "fullScreen" title = "Fullscreen"><i class = "fa fa-arrows-alt  "></i></button>
            <button id = "codeButton" title = "Source"><i class = "fa fa-code  "></i></button>

        </div>