import registerWidget from '../common/registerWidget';

app.initializers.add('afrux/top-posters-widget', () => {
  app.extensionData
    .for('afrux-top-posters-widget')
    .registerSetting({
      setting: 'afrux-top-posters-widget.excluded_usernames',
      name: 'excluded_usernames',
      label: app.translator.trans('afrux-top-posters-widget.admin.excluded_usernames'),
      help: app.translator.trans('afrux-top-posters-widget.admin.excluded_usernames_help'),
      type: 'text',
    })
    .registerSetting({
      setting: 'afrux-top-posters-widget.cache_time',
      name: 'cache_time',
      label: app.translator.trans('afrux-top-posters-widget.admin.cache_time'),
      help: app.translator.trans('afrux-top-posters-widget.admin.cache_time_help'),
      type: 'number',
      min: 0,
      max: 3600,
    });

  registerWidget(app);
});
