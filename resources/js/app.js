require('./bootstrap');

window.addEventListener('DOMContentLoaded', () => {
  require('./actions/create_article_contextmenu');
  require('./actions/create_avatar_contextmenu');
  require('./actions/create_login_contextmenu');
  require('./actions/toggle_sidemenu_expandation');
  require('./actions/avatar_onerror');
  // require('./actions/colorize_content');
  require('./actions/select_search');
  // require('./actions/post_form_content_preview');

  require('./actions/twitter_link_challenge');
  require('./actions/youtube_link_challenge');
  require('./actions/twitch_link_challenge');

  require('./actions/accountSettingsPage');
});
