# Backbone API (ibeo-bbapi)
## Turns Wordpress into an API that spits out Backbone.js-friendly JSON

### How it works
`git clone` this into your-wordpress-project/wp-content/plugins folder. Then activate the Backbone API plugin from your Wordpress dashboard.

To hit your api: `/your-wordpress-project/?bb=true&type=posts&number=5&offset=0&exclude=4` (for example).

### Currently accepted parameters (as of version 0.2.2)
- `bb`: boolean, required. Lets wordpress know that this is a request for the Backbone API.
- `type`: string, required. Currently accepted types are...
  (1) `post`: will pull a single post from the database, by id.
  (2) `posts`: will pull any number of posts from the database.
  (3) `category`: will pull any number of posts from the database, by category id.
  (4) `categories`: will pull a list of all categories from the database.
- `id`: int, required for `type=post` and `type=category`. It has no effect on `type=categories` or `type=posts`. Determines either which post to pull from the database or which category's posts to pull from the database.
- `number`: int, not required. Sets how many posts to pull when `type=categories` or `type=posts`.
- `offset`: int, not required. Sets the offset when `type=categories` or `type=posts`.
- `exclude`: int, not required. As of now, you can only exclude _one_ post from `type=categories` or `type-posts` requests. This will change.

### Want to help?
Send me a pull request!