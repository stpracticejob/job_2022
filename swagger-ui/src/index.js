import SwaggerUI from 'swagger-ui'
import 'swagger-ui/dist/swagger-ui.css';

const spec = require('./cvs.yaml');

SwaggerUI({
  spec,
  dom_id: '#swagger',
});
