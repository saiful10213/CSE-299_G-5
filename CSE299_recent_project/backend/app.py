from flask import Flask, request, jsonify
from flask_cors import CORS
from config import Config
from models import db, User, NIDApplication, BirthApplication, Candidate, Vote, Notice, FAQ, Contact

from flask_mysqldb import MySQL


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


app = Flask(__name__)
CORS(app)

# MySQL Configuration
app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''
app.config['MYSQL_DB'] = 'e_voting_db'
mysql = MySQL(app)

# ----------------- NID SECTION -------------------

@app.route("/nid", methods=["GET"])
def get_nids():
    cursor = mysql.connection.cursor()
    cursor.execute("SELECT * FROM nid")
    data = cursor.fetchall()
    return jsonify(data)

@app.route("/nid", methods=["POST"])
def create_nid():
    data = request.get_json()
    cursor = mysql.connection.cursor()
    cursor.execute("""
        INSERT INTO nid (nid_number, full_name, father_name, mother_name, dob, correction_type)
        VALUES (%s, %s, %s, %s, %s, %s)
    """, (
        data["nid_number"], data["full_name"], data["father_name"],
        data["mother_name"], data["dob"], data["correction_type"]
    ))
    mysql.connection.commit()
    return jsonify({"message": "NID correction submitted"}), 201

@app.route("/nid/<int:id>", methods=["PUT"])
def update_nid(id):
    data = request.get_json()
    cursor = mysql.connection.cursor()
    cursor.execute("""
        UPDATE nid SET nid_number=%s, full_name=%s, father_name=%s, mother_name=%s, dob=%s, correction_type=%s
        WHERE id=%s
    """, (
        data["nid_number"], data["full_name"], data["father_name"],
        data["mother_name"], data["dob"], data["correction_type"], id
    ))
    mysql.connection.commit()
    return jsonify({"message": "NID updated successfully"})

@app.route("/nid/<int:id>", methods=["DELETE"])
def delete_nid(id):
    cursor = mysql.connection.cursor()
    cursor.execute("DELETE FROM nid WHERE id = %s", (id,))
    mysql.connection.commit()
    return jsonify({"message": "NID record deleted"})

# ----------------- BIRTH CERTIFICATE SECTION -------------------

@app.route("/birth", methods=["GET"])
def get_births():
    cursor = mysql.connection.cursor()
    cursor.execute("SELECT * FROM birth_certificate")
    data = cursor.fetchall()
    return jsonify(data)

@app.route("/birth", methods=["POST"])
def create_birth():
    data = request.get_json()
    cursor = mysql.connection.cursor()
    cursor.execute("""
        INSERT INTO birth_certificate (
            form_no, child_name, father_name, mother_name, dob,
            house_no, road_no, road_name, village_name, word_no,
            union_name, thana, post_office, district, division,
            nationality, issue_date, issued_by, chairman_signature, parent_signature
        ) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
    """, (
        data["form_no"], data["child_name"], data["father_name"], data["mother_name"],
        data["dob"], data["house_no"], data["road_no"], data["road_name"], data["village_name"],
        data["word_no"], data["union_name"], data["thana"], data["post_office"],
        data["district"], data["division"], data["nationality"], data["issue_date"],
        data["issued_by"], data["chairman_signature"], data["parent_signature"]
    ))
    mysql.connection.commit()
    return jsonify({"message": "Birth certificate submitted"}), 201

@app.route("/birth/<int:id>", methods=["PUT"])
def update_birth(id):
    data = request.get_json()
    cursor = mysql.connection.cursor()
    cursor.execute("""
        UPDATE birth_certificate SET
            form_no=%s, child_name=%s, father_name=%s, mother_name=%s, dob=%s,
            house_no=%s, road_no=%s, road_name=%s, village_name=%s, word_no=%s,
            union_name=%s, thana=%s, post_office=%s, district=%s, division=%s,
            nationality=%s, issue_date=%s, issued_by=%s, chairman_signature=%s, parent_signature=%s
        WHERE id=%s
    """, (
        data["form_no"], data["child_name"], data["father_name"], data["mother_name"],
        data["dob"], data["house_no"], data["road_no"], data["road_name"], data["village_name"],
        data["word_no"], data["union_name"], data["thana"], data["post_office"],
        data["district"], data["division"], data["nationality"], data["issue_date"],
        data["issued_by"], data["chairman_signature"], data["parent_signature"], id
    ))
    mysql.connection.commit()
    return jsonify({"message": "Birth certificate updated"})

@app.route("/birth/<int:id>", methods=["DELETE"])
def delete_birth(id):
    cursor = mysql.connection.cursor()
    cursor.execute("DELETE FROM birth_certificate WHERE id = %s", (id,))
    mysql.connection.commit()
    return jsonify({"message": "Birth certificate deleted"})

# ----------------- VOTING SECTION -------------------

@app.route("/vote", methods=["POST"])
def cast_vote():
    data = request.get_json()
    nid = data.get("nid_number")
    party = data.get("party")

    cursor = mysql.connection.cursor()
    cursor.execute("SELECT * FROM votes WHERE nid_number = %s", (nid,))
    if cursor.fetchone():
        return jsonify({"message": "You have already voted"}), 403

    cursor.execute("INSERT INTO votes (nid_number, party) VALUES (%s, %s)", (nid, party))
    mysql.connection.commit()
    return jsonify({"message": f"Vote cast for {party}"}), 200

@app.route("/votes", methods=["GET"])
def vote_results():
    cursor = mysql.connection.cursor()
    cursor.execute("SELECT party, COUNT(*) AS total_votes FROM votes GROUP BY party")
    results = cursor.fetchall()
    return jsonify(results)

# ----------------- MAIN -------------------

if __name__ == "__main__":
    app.run(debug=True)


if __name__ == '__main__':
    create_app().run(host='0.0.0.0', port=5000)
