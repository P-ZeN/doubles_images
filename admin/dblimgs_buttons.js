(function() {

    /**
     * Question simple courte
     */
    tinymce.PluginManager.add('dblimgs_mce_button', function(editor, url) {


        editor.addButton('dblimgs_mce_button', {
            text: 'Insérer double image',
            tooltip: 'Insérer double image',
            icon: 'image',
            onclick: function() {
                editor.windowManager.open({
                    size: 'large',
                    title: 'Insérer deux images',
                    body: getFormBody(),
                    onsubmit: function(e) {
                        var html = '[dblimgs_images';
                        for (var attr in e.data) {
                            if (e.data[attr].length) {
                                html += ' ' + attr + '="' + e.data[attr] + '"';
                            }
                        }
                        html += ']';
                        editor.insertContent(html);
                    }
                });
            }
        });


        window.wp.mce.views.register('dblimgs_images', {
            initialize: function() {
                var titre = '<div class="dblimgs_main">';

                for (var i = 1; i <= 4; i++) {
                    var img = getAttr(this.text, 'img_' + i);
                    if (img.length) {
                        var alt = getAttr(this.text, 'alt_' + i);
                        var class_name = getAttr(this.text, 'class_' + i);
                        var ratio = getAttr(this.text, 'ratio_' + i);
                        titre += '<div style="flex: ' + ratio + '"><img src="' + img + '" class="' + class_name + '" alt="' + alt + '" title="' + alt + '"/></div>';
                    }

                }
                titre += '</div>';
                this.render(titre);
            },
            edit: function(text, update) {
                editor.windowManager.open({
                    title: 'Modifier double images',
                    body: getFormBody(text),
                    onsubmit: function(e) {
                        var html = '[dblimgs_images';
                        for (var attr in e.data) {
                            if (e.data[attr].length) {
                                html += ' ' + attr + '="' + e.data[attr] + '"';
                            }
                        }
                        html += ']';
                        update(html);
                    },
                });
            },
        });

        function getAttr(str, name) {
            name = new RegExp(name + '=\"([^\"]+)\"').exec(str);
            return name ? window.decodeURIComponent(name[1]) : '';
        }

        function getFormBody(text) {
            var form_body = [];
            var u = 1;
            while (u <= 4) {
                var i = u.toString();
                form_body.push({
                    type: 'textbox',
                    subtype: 'hidden',
                    name: 'id_' + i,
                    id: 'hiddenID_' + i
                }, {
                    type: 'textbox',
                    subtype: 'hidden',
                    name: 'ratio_' + i,
                    id: 'ratio_' + i
                }, {
                    type: 'textbox',
                    readonly: 1,
                    name: 'img_' + i,
                    label: 'Image ' + i,
                    id: 'img_' + i,
                    value: typeof(text !== 'undefined') ? getAttr(text, 'img_' + i) : ''
                }, {
                    id: 'imgbtn_' + i,
                    type: 'button',
                    text: 'Choisir image ' + i,
                    onclick: function(e) {
                        e.preventDefault();
                        var o = this._id.substr(7);
                        var custom_uploader = wp.media.frames.file_frame = wp.media({
                            title: 'Choisir image ' + o,
                            button: { text: 'Image ' + o },
                            multiple: false
                        });
                        custom_uploader.on('select', function() {
                            var attachment = custom_uploader.state().get('selection').first().toJSON();
                            jQuery('#hiddenID_' + o).val(attachment.id);
                            jQuery('#ratio_' + o).val(attachment.width / attachment.height);
                            jQuery('#img_' + o).val(attachment.url);
                        });
                        custom_uploader.open();
                    }
                }, {
                    type: 'textbox',
                    name: 'alt_' + i,
                    label: 'Légende image ' + i,
                    value: typeof(text !== 'undefined') ? getAttr(text, 'alt_' + i) : ''
                }, {
                    id: 'listbox_' + i,
                    type: 'listbox',
                    name: 'class_' + i,
                    label: 'Classe de l\'image',
                    'values': [
                        { text: '', value: '' },
                        { text: 'Camouflage', value: 'camouflage' },
                        { text: 'Bordure scratch', value: 'border_scratch' }
                    ],
                    onPostRender: function() {
                        // Select the second item by default
                        if (typeof(text !== 'undefined')) {
                            var class_val = getAttr(text, 'class_' + this._id.substr(8));
                            this.value(class_val);
                        }
                    }
                });
                u++;
            }
            return form_body;
        }

    });

})();