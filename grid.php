<?php
echo "<div class=\"wrap\">";
echo "<div class=\"icon32\" id=\"icon-edit\"><br></div>";
echo "<h2>Content Sort</h2><br />";

echo "<p class=\"search-box-content\">";
	echo "<input type=\"text\" value=\"\" name=\"word\" id=\"post-search-input\" class=\"input-search-field\">";
	echo "<input type=\"submit\" class=\"button\" value=\"Search Posts\" id=\"do_post_search\">";
echo "</p>";

echo "<h3>Search result</h3>";
echo "<table cellspacing=\"0\" class=\"widefat post fixed\">";
	echo "<thead>";
	echo "<tr>";
		echo "<th class=\"manage-column column-title\" id=\"title\" scope=\"col\">Title</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tr>";
	echo "<td class=\"content_sort_list\">";
		echo "<ul id=\"sortable1\" class=\"connectedSortable\"></ul>";
	echo "</td>";
	echo "</tr>";
echo "</table>";

echo "<h3>Grid</h3>";

echo "<table cellspacing=\"0\" class=\"widefat post fixed\">";

	echo "<thead>";
	echo "<tr>";
		echo "<th class=\"manage-column column-title\" id=\"title\" scope=\"col\">Title</th>";
	echo "</tr>";
	echo "</thead>";

	echo "<tr>";
	echo "<td class=\"content_sort_list\">";
		echo "<ul id=\"sortable2\" class=\"connectedSortable\"></ul>";
	echo "</td>";
	echo "</tr>";

echo "</table>";

echo "</div>";