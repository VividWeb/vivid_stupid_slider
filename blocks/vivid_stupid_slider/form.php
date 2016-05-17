<?php
defined('C5_EXECUTE') or die("Access Denied.");

// LOAD FOR FILE SELECTOR
$fp = FilePermissions::getGlobal();
$tp = new TaskPermission(); ?>
<style type="text/css">
.select-image { display: block; padding: 15px; cursor: pointer; background: #eee; border: 1px solid #cdcdcd; color: #333; vertical-align: center; }
.select-image i { margin-right: 15px; }
.select-image img { max-width: 100%; }
</style>

<style type="text/css">
	.panel-heading { cursor: move; }
    .panel-body { display: none; }
</style>

<p>
<?php print Loader::helper('concrete/ui')->tabs(array(
    array('pane-items', t('Slides'), true),
    array('pane-settings', t('Slider Settings'))
));?>
</p>

<div class="ccm-tab-content" id="ccm-tab-content-pane-items">
    
    <div class="items-container">
        
        <!-- DYNAMIC ITEMS WILL GET LOADED INTO HERE -->
        
    </div>  
    
    <span class="btn btn-success btn-add-item"><?php echo t('Add Item') ?></span> 

</div>

<div class="ccm-tab-content" id="ccm-tab-content-pane-settings">

    <div class="form-group">
        <?php echo $form->label('fx',"Effect"); ?>
        <select name="fx" class="form-control">
            <optgroup label="fade">
                <option value="13"<? if($fx=='13'){echo" selected";}?>><?=t('Fade')?></option>
            </optgroup>
            <optgroup label="Slice Effects">
                <option value="1"<? if($fx=='1'){echo" selected";}?>><?=t('Up Left')?></option>
                <option value="2"<? if($fx=='2'){echo" selected";}?>><?=t('Up Right')?></option>
                <option value="3"<? if($fx=='3'){echo" selected";}?>><?=t('Down Left')?></option>
                <option value="4"<? if($fx=='4'){echo" selected";}?>><?=t('Down Right<')?>/option>
                <option value="5"<? if($fx=='5'){echo" selected";}?>><?=t('Up and Down Left')?></option>
                <option value="6"<? if($fx=='6'){echo" selected";}?>><?=t('Up and Down Right')?></option>
                <option value="7"<? if($fx=='7'){echo" selected";}?>><?=t('Fold Left')?></option>
                <option value="8"<? if($fx=='8'){echo" selected";}?>><?=t('Fold Right')?></option>
            </optgroup>
            <optgroup label="Slide Effects">
                <option value="9"<? if($fx=='9'){echo" selected";}?>><?=t('SlideIn Left')?></option>
                <option value="10"<? if($fx=='10'){echo" selected";}?>><?=t('SlideIn Right')?></option>
                <option value="11"<? if($fx=='11'){echo" selected";}?>><?=t('SlideIn Up')?></option>
                <option value="12"<? if($fx=='12'){echo" selected";}?>><?=t('SlideIn Down')?></option>
            </optgroup>
            <optgroup label="Box Effects">
                <option balue="14"<? if($fx=='14'){echo" selected";}?>><?=t('Box Right')?></option>
                <option balue="15"<? if($fx=='15'){echo" selected";}?>><?=t('Box Left')?></option>
                <option balue="16"<? if($fx=='16'){echo" selected";}?>><?=t('Box Random')?></option>
                <option balue="17"<? if($fx=='17'){echo" selected";}?>><?=t('Box Fade')?></option>
            </optgroup>
        </select>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">                    
                <?php echo $form->label('width', t('Width:')); ?> 
                <div class="input-group">
                    <?php echo $form->text('width',$width?$width:'1140'); ?> 
                    <div class="input-group-addon">px</div> 
                </div>           
            </div>   
        </div>
        <div class="col-xs-6">
            <div class="form-group">                    
                <?php echo $form->label('height', t('Height:')); ?> 
                <div class="input-group">
                    <?php echo $form->text('height',$height?$height:'500'); ?> 
                    <div class="input-group-addon">px</div> 
                </div>           
            </div> 
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">                    
                <?php echo $form->label('speed', t('Speed:')); ?> 
                <div class="input-group">
                    <?php echo $form->text('speed',$speed?$speed:'250'); ?> 
                    <div class="input-group-addon">ms</div> 
                </div>           
            </div>    
        </div>
        <div class="col-xs-6">
            <div class="form-group">                    
                <?php echo $form->label('duration', t('Duration:')); ?> 
                <div class="input-group">
                    <?php echo $form->text('duration',$duration?$duration:'5'); ?> 
                    <div class="input-group-addon">s</div> 
                </div>           
            </div> 
        </div>
    </div>           
        
</div>



<!-- THE TEMPLATE WE'LL USE FOR EACH ITEM -->
<script type="text/template" id="item-template">
    <div class="item panel panel-default" data-order="<%=sort%>">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-6">
                    <h5><i class="fa fa-arrows drag-handle"></i>
                    Slide <%=parseInt(sort)+1%></h5>
                </div>
                <div class="col-xs-6 text-right">
                    <a href="javascript:editItem(<%=sort%>);" class="btn btn-edit-item btn-default"><?=t('Edit')?></a>
                    <a href="javascript:deleteItem(<%=sort%>)" class="btn btn-delete-item btn-danger"><?=t('Delete')?></a>
                </div>
            </div>
        </div>
        <div class="panel-body form-horizontal">
            <!-- IMAGE SELECTOR --->
            <div class="form-group">
                <label class="col-xs-3 control-label"><?php echo t('Select Image') ?></label>
                <div class="col-xs-9">
                    <a href="javascript:chooseImage(<%=sort%>);" class="select-image" id="select-image-<%=sort%>">
                        <% if (thumb.length > 0) { %>
                            <img src="<%= thumb %>" />
                        <% } else { %>
                            <i class="fa fa-picture-o"></i>
                            Choose Image
                        <% } %>
                    </a>
                    <input type="hidden" name="<?php echo $view->field('fID')?>[]" class="image-fID" value="<%=fID%>" />
                </div>
            </div>
            <input class="item-sort" type="hidden" name="<?php echo $view->field('sort')?>[]" value="<%=sort%>"/>
            
            <div class="form-group">
                <label class="col-xs-3 control-label" for="title<%=sort%>"><?=t('Title:')?></label>
                <div class="col-xs-9">
                	<input class="form-control" type="text" name="title[]" id="title<%=sort%>" value="<%=title%>">
                </div>
            </div>   
            
            
            
        </div>
    </div><!-- .item -->
</script>


<script type="text/javascript">

//Edit Button
var editItem = function(i){
	$(".item[data-order='"+i+"']").find(".panel-body").toggle();
};
//Delete Button
var deleteItem = function(i) {
    var confirmDelete = confirm('<?php echo t('Are you sure?') ?>');
    if(confirmDelete == true) {
        $(".item[data-order='"+i+"']").remove();
        indexItems();
    }
};
//Choose Image
var chooseImage = function(i){
	var imgShell = $('#select-image-'+i);
    ConcreteFileManager.launchDialog(function (data) {
        ConcreteFileManager.getFileDetails(data.fID, function(r) {
            jQuery.fn.dialog.hideLoader();
            var file = r.files[0];
            imgShell.html(file.resultsThumbnailImg);
            imgShell.next('.image-fID').val(file.fID)
        });
    });
};

//Index our Items
function indexItems(){
    $('.items-container .item').each(function(i) {
        $(this).find('.item-sort').val(i);
        $(this).attr("data-order",i);
    });
};

$(function(){
    
    //DEFINE VARS
    
        
        //Define container and items
        var itemsContainer = $('.items-container');
        var itemTemplate = _.template($('#item-template').html());
    
    //BASIC FUNCTIONS
    
        //Make items sortable. If we re-sort them, re-index them.
        $(".items-container").sortable({
            handle: ".panel-heading",
            update: function(){
                indexItems();
            }
        });
    
    //LOAD UP OUR ITEMS
        
        //for each Item, apply the template.
        <?php 
        if($items) {
            foreach ($items as $item) { 
        ?>
        itemsContainer.append(itemTemplate({
            //define variables to pass to the template.
            title: '<?php echo addslashes($item['title']) ?>',
            
            //IMAGE SELECTOR
            fID: '<?php echo $item['fID'] ?>',
            <?php if($item['fID']) { ?>
            thumb: '<?php echo File::getByID($item['fID'])->getThumbnailURL('file_manager_listing');?>',
            <?php } else { ?>
            thumb: '',
			<?php } ?>
			
            sort: '<?=$item['sort'] ?>'
        }));
        <?php 
            }
        }
        ?>    
        
        //Init Index
        indexItems();
        
    //CREATE NEW ITEM
        
        $('.btn-add-item').click(function(){
            
            //Use the template to create a new item.
            var temp = $(".items-container .item").length;
            temp = (temp);
            itemsContainer.append(itemTemplate({
                //vars to pass to the template
                title: '',
                
                //IMAGE SELECTOR
                fID: '',
                thumb: '',
                
                sort: temp
            }));
            
            var thisModal = $(this).closest('.ui-dialog-content');
            var newItem = $('.items-container .item').last();
            thisModal.scrollTop(newItem.offset().top);
            
            
            //Init Index
            indexItems();
        });    

});
</script>