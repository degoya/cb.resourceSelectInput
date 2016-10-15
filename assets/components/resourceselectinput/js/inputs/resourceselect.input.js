(function ($, ContentBlocks) {
    $(document).click(function(e) { 
        var select = $('.contentblocks-field-resourceselect select');
        select.prop("size", 1);
    });
    ContentBlocks.fieldTypes.resourceselectinput = function(dom, data) {
        var input = {
            fieldId: data.field,
            id: '',
            pagetitle: '',
            resources: {},
            select: null,
            preview:null
        };
        input.init = function () {
            dom.addClass('contentblocks-field-loading');
            this.select = dom.find('.contentblocks-field-resourceselect select');
            this.filter = dom.find('.contentblocks-field-resourceselect input');
            var contextkey = this.filter.data('contextkey');
            var template = this.filter.data('template');
            var id = this.filter.data('id');
            this.filter.on('keyup', $.proxy(function() {
                this.updateList(this.filter.val(),contextkey,template,id);
                this.select.prop("size", 10);

            }, this));
            input.updateList(this.filter.val(),contextkey,template,id);
            this.select.on('click', $.proxy(function() {
                this.select.prop("size", 1);
            }, this));
        };

        input.loadResources = function() {
        };

        input.loadResourcesComplete = function() {
            this.select.empty();
            this.select.append('<option value="">--- select resource ---</option>');
            $.each(input.resources, function(id, val) {
                var isSelected = '';
                if (data.value) {
                    if (val.id == data.value) {
                        isSelected = 'selected ';
                    }
                }
                input.select.append('<option ' + isSelected + 'value="' + val.id + '">' + val.label + '</option>');
            });
            if (data.value) {
                this.select.val(data.value);
            }
        };

        input.updateList = function(query,context,template,id) {
            var resource_where = data.properties.resource_where || "";
            var resource_context = data.properties.resource_context || "web";
            var resource_limit = data.properties.resource_limit || "";
            var resource_template = data.properties.resource_template || "";
            var sortfield = data.properties.sortfield || "";
            var sortorder = data.properties.sortorder || "";
            var assetsUrl = MODx.config['resourceselectinput.assets_url'] || MODx.config.assets_url + 'components/resourceselectinput/';
            $.ajax({
                dataType: 'json',
                url: assetsUrl + 'connector.php',
                data: {
                    action: 'search',
                    query: query,
                    resource_where: resource_where,
                    resource_context: resource_context,
                    resource_limit: resource_limit,
                    resource_template: resource_template,
                    contextkey: context, 
                    template: template, 
                    id: id, 
                    sortfield: sortfield, 
                    sortorder: sortorder, 
                    field: input.fieldId
                },
                context: this,
                headers: {
                    'modAuth': MODx.siteId
                },
                error: function() {
                    ContentBlocks.alert('Error: Loading Resources');
                },
                success: function(result) {
                    if (!result) {
                        ContentBlocks.alert('Error: ' + result.message);
                    }
                    else {
                        if (result && result.length) {
                            var count = 0;
                            input.resources = [];
                            $.each(result, function(id, val) {
                                input.resources[count] = val;
                                count++;
                            });
                            this.loadResourcesComplete();
                        }
                        else {
                            //ContentBlocks.alert('none_available');
                        }
                    }
                    dom.removeClass('contentblocks-field-loading');
                }
            });
        };
        input.getData = function () {
            return {
                value: dom.find('.contentblocks-field-resourceselect select').val()
            };
        };

        return input;
    };
})(vcJquery, ContentBlocks);