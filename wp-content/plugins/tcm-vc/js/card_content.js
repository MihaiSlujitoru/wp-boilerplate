(function(){
    function closestDescendent(initialSet, filter) {
        var $found = $(),
            $currentSet = initialSet; // Current place
        while ($currentSet.length) {
            $found = $currentSet.filter(filter);
            if ($found.length) break;  // At least one match: break loop
            // Get all children of the current set
            $currentSet = $currentSet.children();
        }
        return $found.first(); // Return first match of the collection
    }

    window.VcCardTitle = vc.shortcode_view.extend({
        changeShortcodeParams: function(model) {
            window.VcCardTitle.__super__.changeShortcodeParams.call(this, model);

            var $title = closestDescendent(this.$el, 'h4.wpb_element_title');

            var card_title = model.getParam('title');

            if(!card_title) {
                card_title = "Title";
            }
     
            $title.text(card_title);
        }
    });
})();