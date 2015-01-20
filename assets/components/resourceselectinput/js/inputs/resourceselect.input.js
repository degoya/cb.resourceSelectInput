(function ($, ContentBlocks) {
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
            this.preview = dom.find('.contentblocks-field-resourceselect-preview');
            var resource_parent_id = data.properties.resource_parent_id || "0";
            var resource_published = data.properties.resource_published || "1";
            var resource_searchable = data.properties.resource_searchable || "1";


            this.select.on('change', $.proxy(function() {
                this.updatePreview(this.select.val());
            }, this));


            $.ajax({
                dataType: 'json',
                url: '/assets/components/resourceselectinput/connector.php',
                data: {
                    action: 'getlist',
                    resource_parent_id: resource_parent_id,
                    resource_published: resource_published,
                    resource_searchable: resource_searchable,
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
                    if (!result.results) {
                        ContentBlocks.alert('Error: ' + result.message);
                    }
                    else {
                        if (result.results && result.results.length) {
                            $.each(result.results, function(id, val) {
                                input.resources[val.id] = val;
                            });
                            this.loadResourcesComplete();
                        }
                        else {
                            ContentBlocks.alert('none_available');
                        }
                    }
                    dom.removeClass('contentblocks-field-loading');
                }
            });

        };

        input.loadResources = function() {
        };

        input.loadResourcesComplete = function() {
            this.select.empty();
            this.select.append('<option></option>');
            $.each(input.resources, function(id, val) {
                input.select.append('<option value="' + id + '">' + val.pagetitle + '</option>');
            });

            if (data.value) {
                this.select.val(data.value);
                input.updatePreview(data.value);
            }
        };

        input.updatePreview = function(id) {
            dom.addClass('contentblocks-field-loading');
            $.ajax({
                dataType: 'json',
                url: '/assets/components/resourceselectinput/connector.php',
                data: {
                    action: 'getpreview',
                    resource_id: id,
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
                    console.log(result);
                    if (!result.results) {
                        ContentBlocks.alert('Error: ' + result.message);
                    }
                    else {
                        if (result.results && result.results.length) {
                            var resource = result.results[0];
                            this.preview.empty();
                            this.preview.append('<p>' + resource.id + '</p>');
                            this.preview.append('<h1>' + resource.pagetitle + '</h1>');
                            this.preview.append('<h2>' + resource.longtitle + '</h2>');
                            this.preview.append('<p>' + resource.description + '</p>');
                        }
                        else {
                            ContentBlocks.alert('none_available');
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
    }
})(vcJquery, ContentBlocks);