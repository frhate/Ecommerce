const jsonServer = require('json-server');
const cors = require('cors');
const server = jsonServer.create();
const router = jsonServer.router('db.json');
const middlewares = jsonServer.defaults();

server.use(cors());
server.use(middlewares);

server.use(jsonServer.bodyParser);
server.post('/register', (req, res, next) => {
    const { name, email, password, password_confirmation } = req.body;

    if (!name || !email || !password || !password_confirmation) {
        return res.status(400).send({
            errors: {
                message: 'All fields are required.'
            }
        });
    }

    if (password !== password_confirmation) {
        return res.status(400).send({
            errors: {
                password_confirmation: ['Password confirmation does not match.']
            }
        });
    }

    const users = router.db.get('users').value();
    const userExists = users.find(user => user.email === email);

    if (userExists) {
        return res.status(400).send({
            errors: {
                email: ['Email already exists.']
            }
        });
    }

    next();
});

server.use(router);
server.listen(3000, () => {
    console.log('JSON Server is running');
});
