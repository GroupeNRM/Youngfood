const routes = require('./fos_js_routes.json');
const router = require('../../vendor/friendsofsymfony/jsroutingbundle/Resources/public/js/router.min.js');
router.setRoutingData(routes);
module.exports = router;