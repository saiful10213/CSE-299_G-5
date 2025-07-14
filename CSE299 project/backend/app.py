from flask import Flask, request, jsonify
from flask_cors import CORS
from config import Config
from models import db, User, NIDApplication, BirthApplication, Candidate, Vote, Notice, FAQ, Contact

def create_app():
    app = Flask(__name__)
    app.config.from_object(Config)
    CORS(app)
    db.init_app(app)

    @app.before_first_request
    def create_tables():
        db.create_all()

    # --- Auth ---
    @app.route('/api/register', methods=['POST'])
    def register():
        data = request.json
        if User.query.filter_by(mobile=data['mobile']).first():
            return jsonify({'error':'Mobile already registered'}), 400
        user = User(mobile=data['mobile'])
        user.set_password(data['password'])
        db.session.add(user)
        db.session.commit()
        return jsonify({'message':'Registered successfully'})

    @app.route('/api/login', methods=['POST'])
    def login():
        data = request.json
        user = User.query.filter_by(mobile=data['mobile']).first()
        if not user or not user.check_password(data['password']):
            return jsonify({'error':'Invalid credentials'}), 401
        return jsonify({'user_id': user.id})

    # --- NID & Birth Application ---
    @app.route('/api/nid/apply', methods=['POST'])
    def apply_nid():
        payload = request.json
        nid = NIDApplication(
            user_id=payload['user_id'],
            front_image_url=payload.get('front_image_url'),
            back_image_url=payload.get('back_image_url')
        )
        db.session.add(nid)
        db.session.commit()
        return jsonify({'message':'NID application submitted'})

    @app.route('/api/birth/apply', methods=['POST'])
    def apply_birth():
        payload = request.json
        birth = BirthApplication(user_id=payload['user_id'])
        db.session.add(birth)
        db.session.commit()
        return jsonify({'message':'Birth application submitted'})

    # --- Voting ---
    @app.route('/api/candidates', methods=['GET'])
    def list_candidates():
        all_ = Candidate.query.all()
        return jsonify([{'id':c.id,'name':c.name,'party':c.party} for c in all_])

    @app.route('/api/vote', methods=['POST'])
    def cast_vote():
        data = request.json
        if Vote.query.filter_by(user_id=data['user_id']).first():
            return jsonify({'error':'Already voted'}), 400
        vote = Vote(user_id=data['user_id'], candidate_id=data['candidate_id'])
        db.session.add(vote)
        db.session.commit()
        return jsonify({'message':'Vote recorded'})

    # --- Notices & FAQs ---
    @app.route('/api/notices', methods=['GET'])
    def get_notices():
        return jsonify([{'id':n.id,'title':n.title,'body':n.body} for n in Notice.query.all()])

    @app.route('/api/faqs', methods=['GET'])
    def get_faqs():
        return jsonify([{'id':q.id,'question':q.question,'answer':q.answer} for q in FAQ.query.all()])

    # --- Contact ---
    @app.route('/api/contact', methods=['POST'])
    def contact():
        data = request.json
        msg = Contact(name=data['name'], email=data['email'], message=data['message'])
        db.session.add(msg)
        db.session.commit()
        return jsonify({'message':'Thank you for reaching out'})

    return app

if __name__ == '__main__':
    create_app().run(host='0.0.0.0', port=5000)
