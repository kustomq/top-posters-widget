import registerWidget from '../common/registerWidget';

app.initializers.add('afrux/top-posters-widget', () => {
  app.extensionData.for('afrux-top-posters-widget').registerSetting({
    setting: 'afrux-top-posters-widget.excluded_usernames',
    name: 'excluded_usernames',
    label: app.translator.trans('afrux-top-posters-widget.admin.excluded_usernames'),
    help: app.translator.trans('afrux-top-posters-widget.admin.excluded_usernames_help'),
    type: 'URL',
  });

  registerWidget(app);
});
