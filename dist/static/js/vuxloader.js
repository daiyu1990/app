  const pluginGroup = _.groupBy(vuxConfig.plugins, function (plugin) {
    return plugin.name
  })
  for (let group in pluginGroup) {
    if (pluginGroup[group].length > 1) {
  pluginGroup[group].length = 1
    }
  }
  

export {pluginGroup} 