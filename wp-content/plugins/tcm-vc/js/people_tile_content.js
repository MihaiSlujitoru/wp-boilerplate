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

    window.VcPeopleTile = vc.shortcode_view.extend({
        changeShortcodeParams: function(model) {
            window.VcPeopleTile.__super__.changeShortcodeParams.call(this, model);

            var $title = closestDescendent(this.$el, 'h4.wpb_element_title');

            var person_title = model.getParam('person_name');

            if(!person_title) {
                person_title = "Person Name";
            }
     
            $title.text(person_title);
        }
    });
})();