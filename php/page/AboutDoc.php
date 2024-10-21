<?php
require_once 'php/page/HtmlDoc.php';

class AboutDoc extends HtmlDoc
{
    public function __construct(string $aPageTitle, string $aDirectory)
    {
        parent::__construct($aPageTitle, $aDirectory);
    }

    protected function showPageContent(): void
    {
        echo "
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi tristique ut magna tincidunt lacinia. Maecenas vitae sodales lorem, a imperdiet justo. Nam sit amet nisl est. Maecenas mi mi, mollis viverra aliquet non, rutrum id nisl. Donec elit lorem, volutpat ac mauris non, egestas venenatis nisi. Donec ut enim vestibulum nisi pellentesque consequat a sed est. Aliquam magna lectus, efficitur ac fringilla eget, blandit quis mauris. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc condimentum massa eros, in pharetra tortor ullamcorper suscipit. Sed ultrices ex a scelerisque mollis. Sed urna quam, pellentesque ut mauris sed, finibus semper sem. Praesent porttitor commodo leo, eget laoreet sapien vehicula at.
            </p>
            <p>
                Aliquam eget dolor gravida, consectetur massa in, placerat lacus. Pellentesque cursus leo rutrum, cursus felis vitae, tincidunt risus. Phasellus auctor rhoncus quam tincidunt ornare. Aliquam aliquet augue eu nisl tempus bibendum nec eget justo. Quisque non posuere lacus. Suspendisse finibus commodo ipsum ut porttitor. Maecenas consequat dictum lorem, eget faucibus lacus congue et. Donec gravida tempor posuere. Quisque in facilisis diam. Integer dapibus risus et sem varius, ac rhoncus urna convallis. In molestie tortor dolor, at mollis lectus venenatis a. Morbi ut lorem at odio vestibulum semper id sit amet lacus. Maecenas scelerisque in sapien a egestas. Quisque euismod vitae erat at faucibus. Donec vitae dignissim eros, et semper libero.
            </p>
            <p>
                Nam diam ante, mollis a commodo ac, lobortis ut nibh. Curabitur quis posuere velit, non semper odio. In in consectetur metus. Nulla commodo viverra nulla eu viverra. Sed at ante at est sollicitudin auctor. Cras nec posuere ante, vel volutpat dui. Nulla faucibus elementum est et efficitur. Donec ac tortor metus. Sed auctor commodo augue sit amet aliquet. Duis cursus diam ac auctor consectetur. Etiam in urna maximus, rutrum sem sed, placerat diam. Sed mattis volutpat convallis. Fusce porta felis massa, eget dignissim augue rutrum ac.
            </p>
            <p>
                Sed sapien neque, faucibus non posuere a, malesuada eget augue. Aenean lacinia, diam vitae rutrum imperdiet, tortor purus lobortis lacus, vel sodales lorem ipsum at ante. Donec malesuada, tortor nec tempus sollicitudin, quam augue placerat diam, sit amet venenatis enim nisi eu magna. Nulla sit amet accumsan purus, a commodo augue. Suspendisse condimentum tellus diam. Suspendisse vitae ex ut metus iaculis bibendum nec at ante. Vestibulum sit amet tortor nibh. Donec efficitur lacinia blandit. Vestibulum sit amet erat malesuada risus euismod bibendum.
            </p>
            <p>
                Maecenas placerat malesuada velit, et finibus velit auctor eget. Suspendisse eu fringilla magna. Morbi urna orci, tincidunt at est quis, accumsan rutrum ipsum. Vestibulum quis mi eu metus suscipit convallis eget sit amet augue. In vel malesuada nisl, tristique ullamcorper est. Sed aliquet, ante vel semper lacinia, lacus massa sodales massa, sit amet rutrum justo orci vitae tortor. Sed posuere et augue eget malesuada. Mauris finibus sagittis molestie. Donec in diam ac turpis egestas ultrices. Donec ante erat, pretium et congue a, lobortis vitae est. Duis tincidunt finibus arcu congue egestas.
            </p>";
    }
}
