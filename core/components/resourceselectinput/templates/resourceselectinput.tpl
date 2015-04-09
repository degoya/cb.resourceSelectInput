<div class="contentblocks-field contentblocks-field-resourceselect">
    <div class="contentblocks-field-actions"></div>
	
	<label for="{%=o.generated_id%}_input">{%=o.name%}</label>
	
    <div class="contentblocks-field-select contentblocks-field-resourceselect" >
        <input data-contextkey="[[+contextKey]]" data-id="[[+id]]" data-template="[[+template]]" style="width: 30%; display:inline-block; float:left;" type="text" placeholder="enter filter keyword" id="{%=o.generated_id%}_resourcefilter" class="resourcefilterfield">
		<select style="width: 70%; display:inline-block;" id="{%=o.generated_id%}-resourceselect"></select>
    </div>
   
    <div class="contentblocks-field-select contentblocks-field-resourceselect-preview">
    </div>
</div>
