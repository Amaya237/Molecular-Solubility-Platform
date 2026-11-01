
import sys
import json

import numpy as np

from predict_solubility import (
    fingerprint,
    load,
    nearest_similarity,
    SIMILARITY_WARN
)


def predict(smiles):

    # Generate molecular fingerprint
    fp = fingerprint(smiles)

    # Check whether SMILES is valid
    if fp is None:
        return {
            "success": False,
            "error": "Invalid SMILES notation."
        }

    # Convert fingerprint to model input format
    x = fp.astype(np.float32)

    # Load trained model and training fingerprints
    model, X = load()

    # Predict solubility
    logs = float(model.predict(x.reshape(1, -1))[0])

    # Classify the result
    cutoff = -4.0
    label = "soluble" if logs >= cutoff else "not soluble"

    # Calculate similarity
    similarity = nearest_similarity(x, X)

    # Generate warning if similarity is low
    warning = None

    if similarity < SIMILARITY_WARN:
        warning = (
            "This molecule is unlike the training data. "
            "Treat the prediction with caution."
        )

    # Return structured result
    return {
        "success": True,
        "smiles": smiles,
        "logS": round(logs, 2),
        "classification": label,
        "similarity": round(similarity, 2),
        "warning": warning
    }


if __name__ == "__main__":

    if len(sys.argv) < 2:
        print(json.dumps({
            "success": False,
            "error": "Please provide a SMILES string."
        }))
        sys.exit(1)

    smiles = sys.argv[1]

    try:
        result = predict(smiles)
        print(json.dumps(result))

    except Exception:
        print(json.dumps({
            "success": False,
            "error": "Prediction failed. Please try again."
        }))
        sys.exit(1)
