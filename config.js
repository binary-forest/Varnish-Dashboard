module.exports = {
  varnishServer: {
    connection: 'localhost:6082 -S secret'
	},
  server: {
  	communityName: 'public'
  },
  dashboard: {
  	updateRate: 1000
  }
};
