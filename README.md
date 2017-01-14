# Primary-Categories
WordPress plugin for setting and displaying primary categories for posts and custom post types*.

This plugin creates a meta box on the post edit screen titled "Primary Category" containing a drop down menu populated with all categories associated with that post**. Selecting a primary category and updating the post saves this data into a custom field with a meta key of "primary-category".

To display a list of all posts with a particular primary category, use the shortcode [primary-category name="cat_name"] where cat_name is the name of the primary category you wish to display. If a name is not specified, the shortcode will default to all posts with "uncategorized" set as the primary category.

*Note: Custom post types must support both categories and custom fields.

**Note: As new categories are added to a post, the post must be updated before those new categories will be available for selection as a primary category.
